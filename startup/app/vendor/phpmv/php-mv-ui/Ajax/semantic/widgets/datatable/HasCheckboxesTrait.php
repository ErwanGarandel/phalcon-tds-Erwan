<?php
namespace Ajax\semantic\widgets\datatable;

use Ajax\JsUtils;
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlLabel;

/**
 * used in DataTable
 * @author jc
 * @property string identifier
 */
trait HasCheckboxesTrait{
	protected $_hasCheckboxes;
	protected $_hasCheckedMessage=false;
	protected $_checkedMessage;
	protected $_checkedClass;

	abstract public function addInToolbar($element,$callback=NULL);

	protected function _runCheckboxes(JsUtils $js){
		$checkedMessageCall="";
		if($this->_hasCheckedMessage){
			$msg=$this->getCheckedMessage();
			$checkedMessageFunction="function updateChecked(){var msg='".$msg[0]."',count=\$('#{$this->identifier} [name=\"selection[]\"]:checked').length,all=\$('#{$this->identifier} [name=\"selection[]\"]').length;
			if(count==1) msg='".$msg[1]."';
						else if(count>1) msg='".$msg["other"]."';
						\$('#checked-count-".$this->identifier."').contents().filter(function() {return this.nodeType == 3;}).each(function(){this.textContent = msg.replace('{count}',count);});
							\$('#toolbar-{$this->identifier} .visibleOnChecked').toggle(count>0);}\$('#toolbar-".$this->identifier." .visibleOnChecked').hide();";
			$checkedMessageCall="updateChecked();";
			if(isset($this->_checkedClass)){
				$checkedMessageCall.="$(this).closest('tr').toggleClass('".$this->_checkedClass."',$(this).prop('checked'));";
			}
			$js->exec($checkedMessageFunction,true);
		}
		$js->execOn("change", "#".$this->identifier." [name='selection[]']", "
				var \$parentCheckbox=\$('#ck-main-ck-{$this->identifier}'),\$checkbox=\$('#{$this->identifier} [name=\"selection[]\"]'),allChecked=true,allUnchecked=true;
				\$checkbox.each(function() {if($(this).prop('checked')){allUnchecked = false;}else{allChecked = false;}});
				if(allChecked) {\$parentCheckbox.checkbox('set checked');}else if(allUnchecked){\$parentCheckbox.checkbox('set unchecked');}else{\$parentCheckbox.checkbox('set indeterminate');};".$checkedMessageCall);
	}

	protected function _generateMainCheckbox(&$captions){
		$ck=new HtmlCheckbox("main-ck-".$this->identifier,"");
		$checkedMessageCall="";
		if($this->_hasCheckedMessage)
			$checkedMessageCall="updateChecked();";

			$ck->setOnChecked($this->_setAllChecked("true").$checkedMessageCall);
			$ck->setOnUnchecked($this->_setAllChecked("false").$checkedMessageCall);
			\array_unshift($captions, $ck);
	}

	protected function _setAllChecked($checked){
		$result="$('#".$this->identifier." [name=%quote%selection[]%quote%]').prop('checked',".$checked.");";
		if(isset($this->_checkedClass)){
			$result.="$('#".$this->identifier." tr').toggleClass('".$this->_checkedClass."',".$checked.");";
		}
		return $result;
	}

	public function getHasCheckboxes() {
		return $this->_hasCheckboxes;
	}

	public function setHasCheckboxes($_hasCheckboxes) {
		$this->_hasCheckboxes=$_hasCheckboxes;
		return $this;
	}

	protected function getCheckedMessage() {
		$result= $this->_checkedMessage;
		if(!isset($result)){
			$result=[0=>"none selected",1=>"one item selected","other"=>"{count} items selected"];
		}
		return $result;
	}

	/**
	 * Defines the message displayed when checkboxes are checked or unchecked
	 * with an associative array 0=>no selection,1=>one item selected, other=>{count} items selected
	 * @param array $_checkedMessage
	 * @return \Ajax\semantic\widgets\datatable\DataTable
	 */
	public function setCheckedMessage(array $_checkedMessage) {
		$this->_checkedMessage=$_checkedMessage;
		return $this;
	}

	/**
	 * @param array $checkedMessage
	 * @param callable $callback
	 */
	public function addCountCheckedInToolbar(array $checkedMessage=null,$callback=null){
		if(isset($checkedMessage))
			$this->_checkedMessage=$checkedMessage;
			$checkedMessage=$this->getCheckedMessage();
			$this->_hasCheckboxes=true;
			$this->_hasCheckedMessage=true;
			$element=new HtmlLabel("checked-count-".$this->identifier,$checkedMessage[0]);
			$this->addInToolbar($element,$callback);
	}

	public function setCheckedClass($_checkedClass) {
		$this->_checkedClass=$_checkedClass;
		return $this;
	}
}