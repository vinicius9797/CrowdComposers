<?php

use Phinx\Migration\AbstractMigration;

class CreatePosts extends AbstractMigration
{
    public function up(){
        //Criar tabela de posts
        $table = $this->table("posts");
        $table->addColumn('title', 'string')
            ->addColumn('body', 'text')
            ->addColumn('created', 'timestamp')
            ->addColumn('modified', 'timestamp')
            ->save();
    }

    public function down(){
        //Dropar tabela
        if($this->hasTable("posts")){
            $this->dropTable("posts");
        }
    }
}
