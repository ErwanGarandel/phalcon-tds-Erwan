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

    }

    public function page2Action(){

    }

}

