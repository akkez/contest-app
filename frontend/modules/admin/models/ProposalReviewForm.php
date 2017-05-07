<?php
/**
 * Created by PhpStorm.
 * Date: 06/05/17
 */

namespace frontend\modules\admin\models;

use frontend\models\Proposal;
use yii\base\Model;

class ProposalReviewForm extends Model
{
    private $_proposal;
    private $oldStatus;

    public $photo1;
    public $photo2;
    public $name;
    public $email;
    public $grade1;
    public $grade2;
    public $grade3;

    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            [['photo1', 'photo2'], 'safe'],
            [['email'], 'email'],
            [['grade1', 'grade2', 'grade3'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function __construct(Proposal $proposal, array $config = [])
    {
        $this->_proposal = $proposal;
        $this->setAttributes($proposal->getAttributes());
        $this->oldStatus = $proposal->status;

        parent::__construct($config);
    }

    public function update()
    {
        $this->_proposal->setAttributes($this->getAttributes(null, ['photo1', 'photo2']));
        $this->_proposal->status = Proposal::STATUS_REVIEWED;

        $updated = $this->_proposal->save();
        if ($updated && $this->oldStatus == Proposal::STATUS_NEW) {
            $this->_proposal->sendEmail();
        }
        return $updated;
    }

    public function attributeLabels()
    {
        return $this->_proposal->attributeLabels();
    }


}