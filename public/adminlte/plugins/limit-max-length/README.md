# jQuery-maxlength
This is a Jquery plugin which uses maxlength attribute to restrict maximum number of characters allowed in the &lt;input> &lt;textarea> element. Also this plugin provides template for displaying the number of characters entered in the &lt;input> &lt;textarea> element.

## Configurable options
**text:** Text to be displayed in the template.   
**position:** Text position in the template.  
**color:** Color of the text displayed in the template.   
**fontSize:** Size of the text displayed in the template.   
**template:** container for the text displayed in the template.   
**showTemplate:** Hide/show the template.   

## Examples
Basic implementation:   
`$("input,textarea").maxlength();`   

Configurable options:   
```
$("input,textarea").maxlength({  
     text: "You have entered {total}/{maxLength}",  
     position: "left",
     color: "green",
     fontSize: "12px",
     template: "<div/>",
     showTemplate: true

});
```  

## Usage       
```
<input type="text" maxlength="10" />

<textarea rows="4" cols="50" maxlength="50"></textarea>

<script type="text/javascript">

  $(document).ready(function () {
      $("input,textarea").maxlength();
   });
        
</script>

