<?php
require_once("../config.php");

switch(strtolower($_REQUEST['action']))
{
    case "getsubcategory" :   
    {
        ?>
        <option value="">Please Select</option>
        <?php
        $getcat = $db->getRows('select * from subcategory where category_id="'.$_POST['category_id'].'"');
        foreach($getcat as $getcati)
        {
            ?>
            <option value="<?php echo $getcati['subcategory_id']; ?>" <?php if($_POST['editid']==$getcati['subcategory_id']){ echo 'selected'; } ?>><?php echo ucfirst($getcati['subcategory_name']); ?></option>
            <?php
        }
        
        break;
    }
    
    case "getattri" :   
    {  
        ?>
        <option value="">Please Select</option>
        <?php
        $getcat = $db->getRows('select * from specification_attribute where spec_category_id="'.$_POST['category_id'].'"');
        
        foreach($getcat as $getcati)
        {
            ?>
        <option value="<?php echo $getcati['specification_attribute_id']; ?>" <?php if($_POST['attr_id']==$getcati['specification_attribute_id']){ echo 'selected'; } ?>><?php echo ucfirst($getcati['attribute']); ?></option>
            <?php
        }
        
        break;
    }
}
?>