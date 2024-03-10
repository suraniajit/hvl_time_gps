<?php if (($files->file_extension == 'pdf') || $files->file_extension == 'PDF') { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" height="50" width="50"/>
    </a>
<?php } else if ($files->file_extension == 'msg') { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://cdn3.iconfinder.com/data/icons/document-file-formats-2/512/11-512.png" height="50" width="50"/>
    </a>
<?php } else if ($files->file_extension == 'eml') { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://cdn3.iconfinder.com/data/icons/file-extension-11/512/eml-file-extension-format-email-512.png" height="50" width="50"/>
    </a>
<?php } else if (($files->file_extension == 'tif') || ($files->file_extension == 'bmp')) { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://cdn3.iconfinder.com/data/icons/pleasant/TIF-Image.png" height="50" width="50"/>
    </a>
<?php } else if (($files->file_extension == 'ppt') || ($files->file_extension == 'pptx')) { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://cdn4.iconfinder.com/data/icons/social-media-logos-6/512/72-powerpoint-512.png" height="50" width="50"/>
    </a>
<?php } else if (($files->file_extension == 'xlsx') || ($files->file_extension == 'xls')) { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://cdn3.iconfinder.com/data/icons/document-icons-2/30/647702-excel-512.png" height="50" width="50"/>
    </a>
<?php } else if ($files->file_extension == 'docx') { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/381_Word_logo-512.png" height="50" width="50"/>
    </a>
<?php } else if ( ($files->file_extension == 'jfif') ||  ($files->file_extension == 'PNG') || ($files->file_extension == 'png') || ($files->file_extension == 'jpeg') || ($files->file_extension == 'jpg')) { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}" height="50" width="50"/>
    </a>
<?php } else { ?>
    <a target="_blank" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
        <img src="https://cdn2.iconfinder.com/data/icons/Radium_Neue_PNGs/256/file.png" height="50" width="50"/>
    </a>
<?php }
?> {{$key+=1}}
<a target="_blank" id="download" download="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}" href="/public/uploads/expense_document/{{$files->emp_id}}/{{$files->document_file}}">
    <span class="fa fa-download fa-lg" style="margin: 10px;"></span> 
</a>

<!--<span class="fa fa-download fa-lg"></span>--> 

