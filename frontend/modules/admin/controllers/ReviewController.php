<?php

namespace frontend\modules\admin\controllers;

use frontend\models\Proposal;
use kartik\mpdf\Pdf;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `admin` module
 */
class ReviewController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $newItems = Proposal::find()->where(['status' => Proposal::STATUS_NEW])->orderBy('id DESC')->all();
        $reviewedItems = Proposal::find()->where(['status' => Proposal::STATUS_REVIEWED])->orderBy('id DESC')->all();

        return $this->render('index', [
            'newItems' => $newItems,
            'reviewedItems' => $reviewedItems,
        ]);
    }

    public function actionView($id)
    {
        /* @var Proposal $proposal */
        $proposal = Proposal::findOne(['id' => $id]);
        if (!$proposal) {
            throw new NotFoundHttpException();
        }

        if (\Yii::$app->request->isPost) {
            $proposal->load(\Yii::$app->request->post());
            $oldStatus = $proposal->status;
            $proposal->status = Proposal::STATUS_REVIEWED;

            if ($proposal->validate() && $proposal->save()) {
                \Yii::$app->session->setFlash('success', 'Изменения сохранены. ' . Html::a('Вернуться к списку работ', ['/admin/review/index']));

                if ($oldStatus != $proposal->status) {
                    $proposal->sendEmail();
                }
            }
        }

        return $this->render('view', [
            'model' => $proposal
        ]);
    }

    public function actionPdf($id)
    {
        $proposal = Proposal::findOne(['id' => $id]);
        if ($proposal == null) {
            echo "Model was not found.\n";
            return;
        }

        $image = is_null($proposal->photo1) ? $proposal->photo2 : $proposal->photo1;
        $file = Yii::getAlias('@frontend/web/' . $image);

        if (!file_exists($file)) {
            echo "Image was not found.\n";
            return;
        }

        $img = imagecreatefrompng($file);
        $cropped = imagecreatetruecolor(200, 200);
        imagecopy($cropped, $img, 0, 0, 0, 0, 200, 200);

        $imagePath = Yii::getAlias('@frontend/web/assets/download/img.jpg');
        $pdfPath = Yii::getAlias('@frontend/web/assets/download/test.pdf');
        imagejpeg($cropped, $imagePath);

        $content = $this->renderPartial('pdf', ['model' => $proposal, 'image' => 'assets/download/img.jpg']);

        echo $content;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'filename' => $pdfPath,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_FILE, //Pdf::DEST_FILE
            'content' => $content,

            'options' => ['title' => 'Test PDF'],
            'methods' => [
//                'SetFooter' => ['{PAGENO}'],
            ]

        ]);
        $pdf->getApi()->showImageErrors = true;
        return $pdf->render();
    }
}
