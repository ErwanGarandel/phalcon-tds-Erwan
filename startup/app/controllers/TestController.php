<?php

class TestController extends \Phalcon\Mvc\Controller
{
    protected $semantic;

    public function initialize(){
        $this->semantic=$this->jquery->semantic();
    }

    public function indexAction()
    {

    }

    public function hideShowAction()
    {
        $ck=$this->semantic->htmlCheckbox("ckShowHide","Afficher/Masquer");
        $message = $this->semantic->htmlMessage("ZONE","Hello");
        $ck->on("change",$message->jsToggle("$(this).prop('checked')"));
        $this->jquery->compile($this->view);
    }

    public function changeCssAction(){
        $btPage1=$this->semantic->htmlButton("btnPage1","Page 1");
        $btPage1->setProperty("data-desc","salut page 1");
        $btPage2=$this->semantic->htmlButton("btnPage2","Page 2");
        $btPage2->setProperty("data-desc","salut page 2");
        $div=$this->semantic->htmlMessage("pageDesc");
        $message=$this->semantic->htmlMessage("pageContent");
        $btPage1->getOnClick("test/page1","#pageContent");
        $btPage1->on("mouseover","$('#pageDesc').html($(this).attr('data-desc'))");
        $btPage2->getOnClick("test/page2","#pageContent");
        $btPage2->on("mouseover","$('#pageDesc').html($(this).attr('data-desc'))");
        $this->jquery->compile($this->view);
    }

    //Avec un groupe de bouttons
 /*   public function changeCss2Action(){
        buttons=$this->semantic->htmlButtonGroups("buttons",["page 1","page 2"]);
        $buttons->setPropertyValues("data-ajax",["page 1","page 2"]);
        $buttons->getOnClick("test","#pageContent",["attr"->"data-ajax"]);
        $this->semantic->htmlMessage("pageContent");
         $this->jquery->compile($this->view);
    }*/

    public function page1Action(){
        $this->view->disable();
        echo"Page1";
        echo "<div id='page2'></div>";
        $this->jquery->get("test/page2","#page2");
        echo $this->jquery->compile();
    }

    public function page2Action(){

    }

    /*Agit sur Page1Action (le code de page 1 est ecrit comme si page1 n'existait pas )*/
    public function getCascade(){
        $semantic=$this->jquery->semantic();
        $bt = $semantic->htmlButton("btLoad","Chargement");
        $bt -> getOnClick("test/page1","#page1");
    }


    public function postFormAction(){
        $form=$this->semantic->htmlForm("frm1");
        $form->addInput("firstname","First Name");
        $form->addInput("lastname","Last Name");
        $form->addButton("btValider","Submit");
        echo $form;
        $this->semantic->htmlMessage("pageContent");
        $form->submitOnClick("btValider","test/postReponse","#div");
        echo $this->semantic->htmlDivider("div","");
        echo $this->jquery->compile($this->view);
    }

    public function postReponseAction()
    {
        if(!empty($_POST['firstname']) && !empty($_POST['lastname'])){
            echo "Ok";
        }else
            echo "pas ok";
    }
}

