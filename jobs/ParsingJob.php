<?php

namespace app\jobs;

use app\models\file\File;
use app\models\page\Page;
use GuzzleHttp\Client;
use phpQuery;
use Throwable;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

/**
 * Класс для парсинга страниц c сайта ТАСС
 */
class ParsingJob extends BaseObject implements JobInterface
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var Page
     */
    public $page;

    /**
     * @var File[]
     */
    public $files;

    /**
     * @param \yii\queue\Queue $queue
     * @return void
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws Throwable
     */
    public function execute($queue)
    {
        try {
            $client = new Client();
            $res = $client->request('GET', $this->url);

            $body = $res->getBody();
            $document = phpQuery::newDocumentHTML($body);

            // Заполняем название из названия новости
            $title = $document->find('.news-header__title');
            $title = pq($title);

            // Если название не заполнилось,
            // то заполняем из названия статьи
            if (!$title->html()) {
                $title = $document->find('.article__title-wrap span');
                $title = pq($title);
            }

            // Если и в этом случае название не заполнилось,
            // то заполняем из названия самой страницы
            if (!$title->html()) {
                $title = $document->find('title');
                $title = pq($title);
            }

            // Заполняем контент
            $content = $document->find('.text-content');
            $content = pq($content);

            // Заполняем дату создания статьи
            $createdAt = $document->find('.news-header__date-date dateformat');
            $createdAt = pq($createdAt);
            $createdAt = $createdAt->attr('time');

            $this->page->title = $title->html();
            $this->page->content = $content->html();
            $this->page->created_at = $createdAt;
            $this->page->status = Page::STATUS_SUCCESS;

            $this->page->save();


            $mainImage = $document->find(".article-header__photo");
            $mainImage = pq($mainImage);
            $mainImage = $mainImage->attr('style');
            if (preg_match('!background-image:.url.(.+).!', $mainImage, $match)) {
                $url = preg_replace("(^https?://)", '', $match[1]);
                $url = str_replace('//', 'http://', $url);
                $mime = 'jpg';
                $filename = Yii::$app->security->generateRandomString(16);

                $file = file_get_contents($url);
                file_put_contents(Yii::getAlias('@app') . '/web' . File::UPLOAD_FILE_DIR . '/' . $filename . ".{$mime}",
                    $file);

                $file = new File();
                $file->page_id   = $this->page->id;
                $file->name      = $filename;
                $file->mime_type = $mime;
                $file->save();
            }

            $images = $document->find(".news img");

            if ($images->htmlOuter()) {
                foreach ($images as $image) {
                    $image = pq($image);
                    if ($image->attr('src')) {
                        $url = preg_replace("(^https?://)", '', $image->attr('src'));
                        $url = str_replace('//', 'http://', $url);
                        $mime = 'jpg';
                        $filename = Yii::$app->security->generateRandomString(16);

                        $file = file_get_contents($url);
                        file_put_contents(Yii::getAlias('@app') . '/web' . File::UPLOAD_FILE_DIR . '/' . $filename . ".{$mime}",
                            $file);

                        $file = new File();
                        $file->page_id   = $this->page->id;
                        $file->name      = $filename;
                        $file->mime_type = $mime;
                        $file->save();
                    }
                }
            }
        } catch (Throwable $exception) {
            $this->page->title = Page::STATUS_FAIL;
            $this->page->status = Page::STATUS_FAIL;
            $this->page->save(true, [Page::ATTR_TITLE, Page::ATTR_STATUS]);
            throw $exception;
        }
    }
}
