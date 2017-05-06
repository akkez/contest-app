<?php

use yii\db\Migration;

class m170506_100259_proposal extends Migration
{
    public function up()
    {
        $this->createTable('proposal', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'photo1' => $this->string()->null(),
            'photo2' => $this->string()->null(),

            'grade1' => $this->integer()->notNull()->defaultValue(0),
            'grade2' => $this->integer()->notNull()->defaultValue(0),
            'grade3' => $this->integer()->notNull()->defaultValue(0),

            'status' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('proposal');
    }

}
