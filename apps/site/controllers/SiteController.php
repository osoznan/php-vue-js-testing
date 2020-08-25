<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace app\site\controllers;

use app\site\components\Storage;
use app\site\components\StorageFactory;
use app\site\models\Acquire;
use osoznan\patri\Request;

/**
 * Class SiteController
 * Working with tasks
 *
 * @package app\Controllers
 */
class SiteController extends \osoznan\patri\Controller {

    public function actionIndex() {
        return $this->render(
            'index'
        );
    }

    public function actionTest() {
        return $this->render(
            'test'
        );
    }

    public function actionSave_acquire() {
        $post = Request::post();

        $className = "\app\site\components\storagetypes\\" . $post['storage_type'];
        if (!class_exists($className)) {
            $this::error404();
            return $this->jsonRender(['error' => 'Неверное имя класса хранилища']);
        }

        $model = new Acquire();
        $model->load(json_decode($post['attributes'], 1));

        /** @var Storage $storage */
        $storage = StorageFactory::createStorage($className, $model);

        if ($storage->validate() && $storage->save()) {
            return 1;
        }

        $this::error404();
        return $this->jsonRender(['error' => $storage->getFirstErrors()]);
    }
}
