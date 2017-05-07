<?php
namespace frontend\tests\unit\models;

use frontend\fixtures\Proposal as ProposalFixture;
use frontend\models\Proposal;
use frontend\modules\admin\models\ProposalReviewForm;

class ProposalReviewFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'proposal' => [
                'class' => ProposalFixture::className(),
                'dataFile' => codecept_data_dir() . 'proposal.php'
            ]
        ]);
    }

    public function testCheckReviewCount() {
        $proposal = $this->tester->grabFixture('proposal', 0);
        $countBefore = Proposal::find()->where(['status' => Proposal::STATUS_NEW])->count();

        $form = new ProposalReviewForm($proposal);
        $form->grade1 = 3;
        $form->grade2 = 5;
        expect($form->update());

        $countAfter = Proposal::find()->where(['status' => Proposal::STATUS_NEW])->count();
        expect($countAfter)->equals($countBefore - 1);
    }

}