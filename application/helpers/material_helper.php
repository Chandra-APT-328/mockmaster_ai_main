<?php  
    defined('BASEPATH') or exit('No direct script access allowed');

function get_material_file_link_by_ext($file){
    $fileExt = pathinfo($file, PATHINFO_EXTENSION);

    if($fileExt == "pdf"){
        return '<a class="btn-transparent btn-sm text-primary" href="javascript:void(0);" data-viewersrc="'.$file.'" onClick="getPDFFile(this);"><img src="'.base_url("assets/images/extensions/pdf.png").'" width="50px"></a>';
    } elseif($fileExt == "doc" || $fileExt == "docx"){
        return '<a class="btn-transparent btn-sm text-primary" href="'.base_url($file).'" target="_blank"><img src="'.base_url("assets/images/extensions/doc.png").'" width="50px"></a>';
    } elseif($fileExt == "xls" || $fileExt == "xlsx"){
        return '<a class="btn-transparent btn-sm text-primary" href="'.base_url($file).'" target="_blank"><img src="'.base_url("assets/images/extensions/xls.png").'" width="50px"></a>';
    } elseif($fileExt == "png"){
        return '<a class="btn-transparent btn-sm text-primary" href="'.base_url($file).'" target="_blank"><img src="'.base_url("assets/images/extensions/png.png").'" width="50px"></a>';
    } elseif($fileExt == "jpg" || $fileExt == "jpeg"){
        return '<a class="btn-transparent btn-sm text-primary" href="'.base_url($file).'" target="_blank"><img src="'.base_url("assets/images/extensions/jpg.png").'" width="50px"></a>';
    } elseif($fileExt == "ppt" || $fileExt == "pptx"){
        return '<a class="btn-transparent btn-sm text-primary" href="'.base_url($file).'" target="_blank"><img src="'.base_url("assets/images/extensions/ppt.png").'" width="50px"></a>';
    } else{
        return '<a class="btn-transparent btn-sm text-primary" href="'.base_url($file).'" target="_blank"><img src="'.base_url("assets/images/extensions/file.png").'" width="50px"></a>';
    }
}