<?php
/**
 * This model is used for uploading file
 * @package    Upload_file_model
 * @author     Vinfotech Team
 * @version    1.0
 *
 */
class Upload_file_model extends Common_Model {

    protected $pathToFolder;  
    protected $headers = array();  
    /* both variable folder and thmb size need to decide */        
    protected $profilebanner_folder         = array("profilebanner", "profilebanner/1200x200", "profilebanner/220x220");
    protected $profilebanner_thumb_size     = array(array('1200','200'), array("220", "220"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $profilebanner_zoom_crop_array= array(1,1,1);

    protected $profile_folder               = array("profile", "profile/36x36", "profile/220x220");
    protected $profile_thumb_size           = array(array("36", "36"), array("220", "220"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $profile_zoom_crop_array      = array(1, 1, 1);

    protected $link_folder               = array("link", "link/36x36", "link/220x220");
    protected $link_thumb_size           = array(array("36", "36"), array("220", "220"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $link_zoom_crop_array      = array(1, 1, 1);

    protected $blog_folder               = array("blog", "blog/220x220");
    protected $blog_thumb_size           = array(array("220", "220"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $blog_zoom_crop_array      = array(1, 1);

    protected $album_folder               = array("album", "album/220x220", "album/700x440" );
    protected $album_thumb_size           = array(array("220", "220"), array("700", "440"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $album_zoom_crop_array      = array(1, 1, 1);

    protected $group_folder                 = array("group", "group/36x36", "group/220x220", "group/700x440");
    protected $group_thumb_size             = array(array("36", "36"), array("220", "220"), array("700", "440"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $group_zoom_crop_array        = array(1, 1, 1, 1);

    protected $wall_folder                  = array("wall", "wall/220x220", "wall/700x440");
    protected $wall_thumb_size              = array(array("220", "220"), array("700", "440"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $wall_zoom_crop_array         = array(1, 1, 1);

    protected $comments_folder              = array("comments", "comments/220x220", "comments/533x300");
    protected $comments_thumb_size          = array(array("220", "220"), array("533", "300"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $comments_zoom_crop_array     = array(1, 1, 1);

    protected $temp_folder                  = array("temp", "temp/192x191", "temp/36x36");
    protected $temp_thumb_size              = array(array("192", "191"), array("36", "36"), array(ADMIN_THUMB_WIDTH, ADMIN_THUMB_HEIGHT));
    protected $temp_zoom_crop_array         = array(1, 1, 1);

    protected $messages_folder                  = array("messages", "messages/220x220");
    protected $messages_thumb_size              = array(array("220","220"));
    protected $messages_zoom_crop_array         = array(1, 1, 1);

    protected $ratings_folder                  = array("ratings", "ratings/220x220");
    protected $ratings_thumb_size              = array(array("220","220"));
    protected $ratings_zoom_crop_array         = array(1, 1, 1);

    protected $category_folder                  = array("category", "category/220x220");
    protected $category_thumb_size              = array(array("220","220"));
    protected $category_zoom_crop_array         = array(1, 1, 1);

    protected $allowed_image_types          = 'gif|jpg|png|JPG|GIF|PNG|jpeg|JPEG|bmp|BMP';
    protected $allowed_image_max_size       = '4096'; //KB
    protected $allowed_image_max_width      = '1024';
    protected $allowed_image_max_height     = '768';

    protected $allowed_video_types          = 'mp4|MP4|webm|WEBM|ogg|OGG|mov|MOV|flv|FLV|mpeg|MPEG|mpg|MPG|wmv|WMV|swf|SWF|asf|ASF|avi|AVI';
    protected $allowed_video_max_size       = '31457280'; //MB

    protected $allowed_message_types        = 'pdf|PDF|pptx|PPTX|doc|DOC|docx|DOCX|txt|TXT|ppt|PPT|xls|XLS|xlsx|XLSX|odt|ODT|gif|jpg|png|JPG|GIF|PNG|jpeg|JPEG|bmp|BMP|docm|DOCM|pps|PPS|ppsx|PPSX|ods|ODS|odp|ODP|csv|CSV|rtf|RTF|m4a|M4A|m4p|M4P|mmf|MMF|mp3|MP3|ra|RA|rm|RM|wav|WAV|wma|WMA|webm|WEBM|ogg|OGG|MP4|mp4|mov|MOV|flv|FLV|mpeg|MPEG|mpg|MPG|wmv|WMV|swf|SWF|asf|ASF';
    protected $allowed_message_max_size     = '4096'; //MB

    /* both variable folder and thmb size need to decide */
    protected $name_skip_chars      = array(
        "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "+", "=", "{", "}",
        "[", "]", "|", "\\", ":", ";", "\"", "'", "<", ",", ">", ".", "?", "/", " "
    );

    protected $VideoExt = array('mp4','ogg','webm');

    protected $MediaSectionIDArray = array(
                                        "profile"=>1,
                                        "group"=>2,
                                        "wall"=>3,
                                        "album"=>4,
                                        "profilebanner"=>5,
                                        "comments"=>6,
                                        "ratings"=>8,
                                        "blog"=>9
                                    );

    protected $DeviceTypeIDArray = array(
                                        "native"=>1,
                                        "iphone"=>2,
                                        "androidphone"=>3,
                                        "ipad"=>4,
                                        "androidtablet"=>5,
                                        "othermobiledevice "=>6
                                    );

    protected $MediaExtensionIDArray = array(
                                        "jpg"=>1,
                                        "jpeg"=>2,
                                        "png"=>3,
                                        "gif"=>4,
                                        "mp4"=>5,
                                        "mov"=>6,
                                        "3gp"=>7,
                                        "avi"=>8,
                                        "doc"=>10,
                                        "docx"=>11,
                                        "txt"=>12,
                                        "ppt"=>13,
                                        "xls"=>14,
                                        "odt"=>15,
                                        "xlsx"=>16,
                                        "pptx"=>17,
                                        "pdf"=>18,
                                        "bmp"=>19,
                                        "docm"=>20,
                                        "pps"=>21,
                                        "ppsx"=>22,
                                        "ods"=>23,
                                        "odp"=>24,
                                        "csv"=>25,
                                        "rtf"=>26,
                                        "m4a"=>27,
                                        "m4p"=>28,
                                        "mmf"=>29,
                                        "mp3"=>30,
                                        "ra"=>31,
                                        "rm"=>32,
                                        "wav"=>33,
                                        "wma"=>34,
                                        "webm"=>35,
                                        "flv"=>36,
                                        "mpeg"=>37,
                                        "mpg"=>38,
                                        "wmv"=>39,
                                        "swf"=>40,
                                        "asf"=>41
                                    );

    function __construct() {
        parent::__construct();    
        $admin_thumb_profile                = "profile/".ADMIN_THUMB_WIDTH .'x'. ADMIN_THUMB_HEIGHT;
        $admin_thumb_group                  = "group/".ADMIN_THUMB_WIDTH .'x'. ADMIN_THUMB_HEIGHT;
        $admin_thumb_wall                   = "wall/".ADMIN_THUMB_WIDTH .'x'. ADMIN_THUMB_HEIGHT;
        $admin_thumb_album                  = "album/".ADMIN_THUMB_WIDTH .'x'. ADMIN_THUMB_HEIGHT;
        $admin_thumb_comments               = "comments/".ADMIN_THUMB_WIDTH .'x'. ADMIN_THUMB_HEIGHT;
        $admin_thumb_profilebanner_folder   = "profilebanner/".ADMIN_THUMB_WIDTH .'x'. ADMIN_THUMB_HEIGHT;

        $this->profile_folder[]         = $admin_thumb_profile;
        $this->group_folder[]           = $admin_thumb_group;
        $this->wall_folder[]            = $admin_thumb_wall;
        $this->album_folder[]           = $admin_thumb_album;
        $this->comments_folder[]        = $admin_thumb_comments;
        $this->profilebanner_folder[]   = $admin_thumb_profilebanner_folder;

        if (strtolower(IMAGE_SERVER) == 'remote') { //if upload on s3 is enabled
            $this->load->library('S3');
        }
        $this->pathToFolder = ROOT_FOLDER;
        $this->headers = array("Cache-Control" => "max-age=315360000", "Expires" => gmdate("D, d M Y H:i:s T", strtotime("+1 years")));
    }

    public function uploadProfilePicture($Data,$UserID){
        if($Data['MediaGUID'])
        {
            //$media_details  = get_detail_by_guid($Data['MediaGUID'], 21, "MediaSectionID, ImageName", 2);
            
            $this->db->select('M.ImageName,MS.MediaSectionAlias,MS.MediaSectionID');
            $this->db->from(MEDIASECTIONS.' MS');
            $this->db->join(MEDIA.' M','M.MediaSectionID=MS.MediaSectionID','left');
            $this->db->where('M.MediaGUID',$Data['MediaGUID']);
            $media_query = $this->db->get();
            $media_details = $media_query->row_array();
            $MediaSectionID = $media_details['MediaSectionID'];
            if($MediaSectionID==1)
            {
                $Data['IsMediaExisted'] = 0;
            }

        }
        if($Data['IsMediaExisted']){
            $d = $Data;
            $d['ImageUrl'] = $Data['FilePath'].$Data['CropSize'].'/'.$Data['ImageName'];
            $Data['DeviceType'] = 'Web';
            $get_details = $this->saveFileFromUrl($Data);
            $Data['ImageName'] = $get_details['Data']['ImageName'];
            $Data['MediaGUID'] = $get_details['Data']['MediaGUID'];

            if(isset($media_details))
            {
                if($media_details['MediaSectionID']!=1)
                {
                    $file_full_path = PATH_IMG_UPLOAD_FOLDER.$media_details['MediaSectionAlias'].'/'.$media_details['ImageName'];
                    $file_full_path2 = PATH_IMG_UPLOAD_FOLDER.$media_details['MediaSectionAlias'].'/org_'.$media_details['ImageName'];
                    $destinationFile = PATH_IMG_UPLOAD_FOLDER.'profile/'.$Data['ImageName'];
                    $destinationFile2 = PATH_IMG_UPLOAD_FOLDER.'profile/org_'.$Data['ImageName'];
                    if(strtolower(IMAGE_SERVER) == 'remote')
                    {
                        $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
                        $s3->copyObject(BUCKET, $file_full_path, BUCKET, $destinationFile, S3::ACL_PUBLIC_READ);
                        $s3->copyObject(BUCKET, $file_full_path2, BUCKET, $destinationFile2, S3::ACL_PUBLIC_READ);
                    }
                    else
                    {
                        copy(IMAGE_SERVER_PATH.$file_full_path,$destinationFile);
                        copy(IMAGE_SERVER_PATH.$file_full_path2,$destinationFile2);
                    }
                }
            }
        }
        $SourceImage = $Data['FilePath'].$Data['CropSize'].'/'.$Data['ImageName'];
        @file_put_contents($SourceImage,base64_decode($Data['ImageData']));
        
        if(strtolower(IMAGE_SERVER) == 'remote'){
            $s3_path        = $SourceImage;
            $s3             = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
            $is_s3_upload   = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
        }
        //$this->resizeImage($NewImage,$SourceImage,$height,$width,$MaintainRatio=TRUE);
        $thumb_size = $Data['Type'].'_thumb_size';
        $totalSize = 0;
        $size = @filesize($Data['FilePath'].$Data['ImageName']);
        if(isset($size) && !empty($size)) {
            $totalSize = $size;// /1024;

        }
        foreach($this->$thumb_size as $i=>$val){
            $NewImage = $Data['FilePath'].$val[0].'x'.$val[1].'/'.$Data['ImageName'];
            //echo "SourceImage = ".$SourceImage;
            $totalSize = $totalSize + $this->resizeImage($NewImage,$SourceImage,$val[0],$val[1],TRUE);
        }
        if (strtolower(IMAGE_SERVER) == 'remote') {
            @unlink($SourceImage);
        }
        $this->load->model('media/media_model');
        $this->db->set('Size',$totalSize);
        $this->db->set('MediaSizeID',$this->media_model->getMediaSizeID($totalSize));
        $this->db->where('MediaGUID',$Data['MediaGUID']);
        $this->db->update(MEDIA);

        $this->updateProfilePicture($Data['MediaGUID'],$Data['ImageName'],$UserID,$Data['ModuleID'],$Data['ModuleEntityGUID']);
    }

    /**
     * [uploadTempFile Used to upload file temporary]
     * @param [type] $Data [input data for upload file Request]
     * @return [Object] [json object]
     */
    function uploadTempFile($Data,$Return){

        $chk_folder = PATH_IMG_UPLOAD_FOLDER;

        $this->check_folder_exist($chk_folder, array($Data['Type']));

        $config['upload_path']      = PATH_IMG_UPLOAD_FOLDER . $Data['Type']."/";
        $config['allowed_types']    = $this->allowed_image_types;
        $config['max_size']         = $this->allowed_image_max_size;
        $config['min_width']        = 800;
        $config['min_height']       = 300;
        $config['encrypt_name']     = TRUE;

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('qqfile')){
            $Return['ResponseCode'] = 511;
            $Errors = $this->upload->error_msg;
            if(!empty($Errors)){
                $Return['Message'] =  $Errors['0']; // first message
            }else{
                $Return['Message'] =  "Unable to fetch error code."; // first message
            }
            return $Return;
            //Shows all error messages as a string              
        } else {
            $data = $this->upload->data();
            $Return['Data']['FilePath'] = IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$Data['Type'].'/'.$data['file_name'];
            return $Return;
        }
    }

    /**
     * [uploadImage Used to upload file]
     * @param [type] $Data [input data for upload file Request]
     * @return [Object] [json object]
     */
    function uploadImage($Data,$generateThumb=1){     

        $Return['Message']      = lang('success');
        $Return['ResponseCode'] = 200;
        $Return['Data']         =array();

        $Type       = strtolower($Data['Type']);
        $DeviceType = strtolower($Data['DeviceType']);

        $ModuleID   = isset($Data['ModuleID']) ? $Data['ModuleID'] : 0 ;
        $EntityGUID = isset($Data['ModuleEntityGUID']) ? $Data['ModuleEntityGUID'] : 0 ;
        $EntityID   = 0;
        if($EntityGUID && $ModuleID){
            $EntityID   = get_detail_by_guid($EntityGUID, $ModuleID);
        }
        
        $folder_arr = $Type . '_folder';
        $thumb_arr  = $Type . '_thumb_size';
        $zc_arr     = $Type . '_zoom_crop_array';
 
        $dir_name   = PATH_IMG_UPLOAD_FOLDER . $Type;
        $chk_folder = PATH_IMG_UPLOAD_FOLDER;

        $this->check_folder_exist($chk_folder, $this->$folder_arr);

        $config['upload_path']      = $dir_name . "/";
        $config['allowed_types']    = $this->allowed_image_types;
        $config['max_size']         = $this->allowed_image_max_size;
        if($Type == 'messages'){
            $config['allowed_types']    = $this->allowed_message_types;
            $config['max_size']         = $this->allowed_message_max_size;
        }
        /*$config['max_width']        = $this->allowed_image_max_width;
        $config['max_height']       = $this->allowed_image_max_height;*/
        $config['encrypt_name']     = TRUE;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('qqfile')){
            $Return['ResponseCode'] = 511;
            $Errors = $this->upload->error_msg;
            if(!empty($Errors)){
                $Return['Message'] =  $Errors['0']; // first message
            }else{
                $Return['Message'] =  "Unable to fetch error code."; // first message
            }
            return $Return;
            //Shows all error messages as a string              
        } else {
            $UploadData = $this->upload->data();
            rename(
                $UploadData['full_path'],
                $UploadData['file_path'].'/'.'org_'.$UploadData['file_name']
            );
            // Copy original image and reduce its quality to 75%
            $this->generate_thumb($UploadData['full_path'], $dir_name, $UploadData['file_name'], array(array($UploadData['image_width'],$UploadData['image_height'])), $this->$zc_arr, 1,$this->pathToFolder,$Type,1);
            $totalSize = 0;
            //thumb code

            $file_name_ext  = explode('.', $UploadData['file_name']);
            $ext            = end($file_name_ext);
            $ext            = strtolower($ext);
            if(in_array($ext,$this->VideoExt)){
                $this->create_video_thumb($UploadData);
            } else {
                if($generateThumb){
                    $totalSize = $this->generate_thumb(
                        $UploadData['full_path'], 
                        $dir_name, 
                        $UploadData['file_name'], 
                        $this->$thumb_arr, 
                        $this->$zc_arr,
                        1,
                        $this->pathToFolder,
                        $Type
                    );
                }
            }
            
            $OrgFullPath = $UploadData['full_path'];
            $OrgFileName = $UploadData['file_name'];

            $UploadFilePathArr = explode('/', $UploadData['full_path']);
            $UploadFilePathArr[count($UploadFilePathArr)-1] = 'org_'.$UploadFilePathArr[count($UploadFilePathArr)-1];
            $UploadData['full_path'] = implode('/', $UploadFilePathArr);

            $UploadFileNameArr = explode('/', $UploadData['file_name']);
            $UploadFileNameArr[count($UploadFileNameArr)-1] = 'org_'.$UploadFileNameArr[count($UploadFileNameArr)-1];
            $UploadData['file_name'] = implode('/', $UploadFileNameArr);


            $MimeType = mime_content_type($UploadData['full_path']);
            if (strtolower(IMAGE_SERVER) == 'remote') {               

                $s3_path        = $dir_name .'/' . $UploadData['file_name'];
                $s3             = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
                $is_s3_upload   = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ,$this->headers,$MimeType);
                @unlink($s3_path);
            }
            $image_type         = $ext;
            $MediaSectionID     = isset($this->MediaSectionIDArray[$Type]) ? $this->MediaSectionIDArray[$Type] : 1;
            $DeviceID           = $this->DeviceTypeID;
            if(empty($DeviceID)) {
                $DeviceID           = isset($this->DeviceTypeIDArray[$DeviceType]) ? $this->DeviceTypeIDArray[$DeviceType] : 1;
            }

            $MediaExtensionID   = isset($this->MediaExtensionIDArray[$image_type]) ? $this->MediaExtensionIDArray[$image_type] : 1;
            $totalSize = $UploadData['file_size']+$totalSize;
           

            //$AlbumID = $this->get_media_section_album_id($Type, $this->UserID, $ModuleID, $EntityID, $MediaExtensionID);

            $Media = array(
                'MediaGUID'         => get_guid(),
                'UserID'            => $this->UserID,
                'OriginalName'      => $UploadData['orig_name'],
                'MediaSectionID'    => $MediaSectionID,
                'ModuleID'          => $ModuleID,
                'ModuleEntityID'    => $EntityID,
                'ImageName'         => $OrgFileName,
                'ImageUrl'          => $OrgFileName,
                'Size'              => $totalSize, //The file size in kilobytes
                'DeviceID'          => $DeviceID,
                'SourceID'          => $this->SourceID,
                'MediaExtensionID'  => $MediaExtensionID,
                'MediaSectionReferenceID'=>0,
                'CreatedDate'       => get_current_date('%Y-%m-%d %H:%i:%s'),
                'StatusID'          => 1, // default pending
                'IsAdminApproved'   => 1,
                'AbuseCount'        => 0,
                'AlbumID'           => 0,
                'Caption'           => "" ,
                'MediaSizeID'       => $this->getMediaSizeID($totalSize)           
            ); 

            $this->saveMedia($Media,$this->UserID);
            $this->checkMediaCounts($Media,true);
            //insert in to media table with status pending which means in 24 hours this file will be deleted from server.
            //MediaGUID, MediaName
            $Return['Data']=array(
                "MediaGUID"=>$Media['MediaGUID'],
                "ImageName"=>$Media['ImageName'],
                "ImageServerPath"=>IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$Type,
                "OriginalName"=>$UploadData['orig_name'],
                "MediaType"=>'PHOTO',
                "MediaSectionAlias"=>($MediaSectionID==4?'album':'')
            );
        }
        return $Return;
    }

    function get_media_section_album_id($media_section_type, $user_id, $module_id, $module_entity_id, $extension_id="")
    {
        $album_name = "";
        $album_id   = 0;
        if($media_section_type == "profile") 
        {
            $album_name = DEFAULT_PROFILE_ALBUM;
        }
        if($media_section_type == "profilebanner") 
        {
            $album_name = DEFAULT_PROFILECOVER_ALBUM;
        }

        /*if(($media_section_type == "ratings" || $media_section_type == "wall") && !empty($extension_id)) 
        {
            $this->db->select('MediaTypeID');
            $this->db->from(MEDIAEXTENSIONS);
            $this->db->where(array('MediaExtensionID'=>$extension_id));
            $query = $this->db->get();
            $MediaTypeID = 0;
            if($query->num_rows()>0)
            {
                $result = $query->row_array();
                $MediaTypeID = $result['MediaTypeID'];
            }

            if($media_section_type == "wall") 
            {
                $album_name = DEFAULT_WALL_ALBUM;
                if($MediaTypeID == 1)
                {
                    $album_name = DEFAULT_WALL_ALBUM;
                }
            }
            if($media_section_type == "ratings") 
            {
                $album_name = 'Rating Videos';
                if($MediaTypeID == 1)
                {
                    $album_name = 'Rating Photos';
                }
            }
        }*/
        //echo $album_name.' - '.$module_id.' - '.$module_entity_id.' - '.$extension_id;
        if(!empty($album_name) && !empty($module_id) && !empty($module_entity_id))
        {
            $album_id = get_album_id($user_id, $album_name, $module_id, $module_entity_id);   
        }
        return $album_id; 
    }
    /**
     * [saveFileFromUrl Used to upload file from URL]
     * @param [type] $Data [input data for upload file Request]
     * @return [Object] [json object]
     */
    function saveFileFromUrl($Data) 
    {
        $Return['Message']      = lang('success');
        $Return['ResponseCode'] = 200;
        $Return['Data']         =array();

        $FileName = substr(md5(uniqid(mt_rand(), true)), 0, 8) . time().'.jpg';
            
        $this->load->library('curl');
        $this->load->helper('file');

        $Type       = strtolower($Data['Type']);
        $DeviceType = strtolower($Data['DeviceType']);
        $ImageData  = $Data['ImageData'];
        $ModuleID   = $Data['ModuleID'];
        $EntityGUID = $Data['ModuleEntityGUID'];
        $EntityID   = get_detail_by_guid($EntityGUID, $ModuleID);
        
        $folder_arr = $Type . '_folder';
        $thumb_arr  = $Type . '_thumb_size';
        $zc_arr     = $Type . '_zoom_crop_array';

        $dir_name   = PATH_IMG_UPLOAD_FOLDER . $Type;
        $chk_folder = PATH_IMG_UPLOAD_FOLDER;

        $this->check_folder_exist($chk_folder, $this->$folder_arr);
        $totalSize = 0;
        if(isset($Data['CanCrop']))
        {
            $FilePath = IMAGE_ROOT_PATH.$Type.'/';
            if(isset($Data['ImageUrl']) && !$Data['ImageUrl']){
                @file_put_contents($FilePath.$FileName,base64_decode($ImageData));
            } else {
                write_file($dir_name . "/". $FileName, $ImageData);
            }
            $size = @filesize($FilePath.$FileName);
            if(isset($size) && !empty($size)) {
                $totalSize = $totalSize + ($size); //1024

            }
            if($this->$thumb_arr)
            {
                foreach($this->$thumb_arr as $folder)
                {
                    $w = $folder[0];
                    $h = $folder[1];
                    if($w==1200 && $h==200)
                    {
                        $totalSize = $totalSize + $this->cropFile($FilePath, $FileName, $Data['ImageWidth'], $Data['ImageHeight'], 1920, $Data['CropYAxis'], $folder[0].'x'.$folder[1].'/', $dir_name, $Data['CropXAxis']);
                    }
                    else
                    {
                        $totalSize = $totalSize + $this->create_cover_thumb($FileName,$w,$h);
                    }
                }
            }
        } else {
            write_file($dir_name . "/". $FileName, $ImageData);
            write_file($dir_name . "/org_". $FileName, $ImageData);

            //thumb code
            $totalSize = $this->generate_thumb(
                                    $dir_name . "/". $FileName, 
                                    $dir_name, 
                                    $FileName, 
                                    $this->$thumb_arr, 
                                    $this->$zc_arr,
                                    1,
                                    $this->pathToFolder,
                                    $Type
                                );
        }

        if (strtolower(IMAGE_SERVER) == 'remote') {
            $s3_path = $dir_name . "/". $FileName;
            $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
            $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
        }
        $MediaSectionID     = isset($this->MediaSectionIDArray[$Type]) ? $this->MediaSectionIDArray[$Type] : 1;
        $DeviceID           = isset($this->DeviceTypeID) ? $this->DeviceTypeID : '';
        if(empty($DeviceID)) {
            $DeviceID           = isset($this->DeviceTypeIDArray[$DeviceType]) ? $this->DeviceTypeIDArray[$DeviceType] : 1;
        }
        if(isset($Data['SourceID'])) {
            $this->SourceID = $Data['SourceID'];
        }
        if(isset($Data['UserID'])) {
            $this->UserID = $Data['UserID'];
        }
        $MediaExtensionID   = 1;

        $Media = array(
            'MediaGUID'         => get_guid(),
            'UserID'            => $this->UserID,
            'MediaSectionID'    => $MediaSectionID,
            'ModuleID'          => $ModuleID,
            'ModuleEntityID'    => $EntityID,
            'ImageName'         => $FileName,
            'ImageUrl'          => $FileName,
            'Size'              => $totalSize, //The file size in kilobytes
            'DeviceID'          => $DeviceID,
            'SourceID'          => $this->SourceID,
            'MediaExtensionID'  => $MediaExtensionID,
            'MediaSectionReferenceID'=>0,
            'CreatedDate'       => get_current_date('%Y-%m-%d %H:%i:%s'),
            'StatusID'          => 1, // default pending
            'IsAdminApproved'   => 1,
            'AbuseCount'        => 0,
            'AlbumID'           => 0,
            'Caption'           => "",
            'MediaSizeID'       => $this->getMediaSizeID($totalSize)                    
        ); 
        $MediaID = $this->saveMedia($Media,$this->UserID);
        $this->checkMediaCounts($Media,true);
        //insert in to media table with status pending which means in 24 hours this file will be deleted from server.
        //MediaGUID, MediaName
        $Return['Data']=array(
            "MediaID"   => $MediaID,
            "MediaGUID" => $Media['MediaGUID'],
            "ImageName" => $Media['ImageName'],
            "ImageServerPath"=>IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$Type
        );
        
        return $Return;
    }

    function apply_default_theme($data)
    {
        $return['Message']      = lang('success');
        $return['ResponseCode'] = 200;
        $return['Data']         =array();

        $file_name = substr(md5(uniqid(mt_rand(), true)), 0, 8) . time().'.jpg';

        $cover_theme   = $data['CoverTheme'];
        $image_path     = ROOT_PATH."/assets/img/bannerTheme/".$cover_theme.".jpg"; 
            
        $this->load->helper('file');

        $type        = strtolower($data['Type']);
        $device_type = strtolower($data['DeviceType']);
        //$image_data  = $data['ImageData'];
        $module_id   = $data['ModuleID'];
        $entity_guid = $data['ModuleEntityGUID'];
        $entity_id   = get_detail_by_guid($entity_guid, $module_id);
        
        $folder_arr = $type . '_folder';
        $thumb_arr  = $type . '_thumb_size';
        $zc_arr     = $type . '_zoom_crop_array';

        $dir_name   = PATH_IMG_UPLOAD_FOLDER . $type;
        $chk_folder = PATH_IMG_UPLOAD_FOLDER;

        $this->check_folder_exist($chk_folder, $this->$folder_arr);
        $total_size = 0;

        $file_full_path = $dir_name.'/'.$file_name;

        //write_file($file_full_path, $image_data);

        copy($image_path, $file_full_path);
        copy(ROOT_PATH.'/'.$file_full_path, $dir_name . "/org_". $file_name);

        $size = @filesize($file_full_path);
        if(isset($size) && !empty($size)) 
        {
            $total_size = $total_size + ($size); //1024

            $total_size = 2 * $total_size; //for org image
        }
        
        if (strtolower(IMAGE_SERVER) == 'remote') 
        {
            $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
            $s3_path = $dir_name . "/". $file_name;            
            $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);

            $s3_path = $dir_name . "/org_". $file_name;
            $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
        }

        if($this->$thumb_arr)
        {
            foreach($this->$thumb_arr as $folder)
            {
                $w = $folder[0];
                $h = $folder[1];
                if($w==1200 && $h==200)
                {                    
                    $destination_path = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                    if (strtolower(IMAGE_SERVER) == 'remote') 
                    {
                        $res = $s3->copyObject(BUCKET, $file_full_path, BUCKET, $destination_path, S3::ACL_PUBLIC_READ);
                        $total_size = $total_size + ($size);                        
                    }
                    else
                    {
                        $file_location = ROOT_PATH. '/' .$dir_name.'/'.$file_name;
                        copy(ROOT_PATH.'/'.$file_full_path, $destination_path);
                        $total_size = $total_size + ($size);                        
                    }
                }
                else
                {
                    $image_path     = ROOT_PATH."/assets/img/bannerTheme/".$cover_theme.$cover_theme.".jpg";
                    $s3_path   = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                    copy($image_path, $s3_path);
                    if (strtolower(IMAGE_SERVER) == 'remote') 
                    {                      
                        $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);

                        $size1 = @filesize($image_path);
                        if(isset($size1) && !empty($size1)) {
                            $total_size = $total_size + $size1;
                        }
                        @unlink($s3_path); 
                    }
                    //$total_size = $total_size + $this->create_cover_thumb($file_name, $w, $h);
                }
            }
        }

        if (strtolower(IMAGE_SERVER) == 'remote') 
        {
            @unlink($file_full_path);
            @unlink($dir_name . "/org_". $file_name);
        }

        $media_section_id     = isset($this->MediaSectionIDArray[$type]) ? $this->MediaSectionIDArray[$type] : 1;
        $device_id           = isset($this->DeviceTypeID) ? $this->DeviceTypeID : '';
        if(empty($device_id)) {
            $device_id           = isset($this->DeviceTypeIDArray[$device_type]) ? $this->DeviceTypeIDArray[$device_type] : 1;
        }
        if(isset($Data['SourceID'])) {
            $this->SourceID = $Data['SourceID'];
        }
        if(isset($Data['UserID'])) {
            $this->UserID = $Data['UserID'];
        }
        $media_extension_id   = 1;

        $media = array(
            'MediaGUID'         => get_guid(),
            'UserID'            => $this->UserID,
            'MediaSectionID'    => $media_section_id,
            'ModuleID'          => $module_id,
            'ModuleEntityID'    => $entity_id,
            'ImageName'         => $file_name,
            'ImageUrl'          => $file_name,
            'Size'              => $total_size, //The file size in kilobytes
            'DeviceID'          => $device_id,
            'SourceID'          => $this->SourceID,
            'MediaExtensionID'  => $media_extension_id,
            'MediaSectionReferenceID'=>0,
            'CreatedDate'       => get_current_date('%Y-%m-%d %H:%i:%s'),
            'StatusID'          => 1, // default pending
            'IsAdminApproved'   => 1,
            'AbuseCount'        => 0,
            'AlbumID'           => 0,
            'Caption'           => "",
            'MediaSizeID'       => $this->getMediaSizeID($total_size)                    
        ); 
        $media_id = $this->saveMedia($media, $this->UserID);
        $this->checkMediaCounts($media,true);
        //insert in to media table with status pending which means in 24 hours this file will be deleted from server.
        //MediaGUID, MediaName
        /*$return['Data']=array(
            "MediaID"   => $media_id,
            "MediaGUID" => $media['MediaGUID'],
            "ImageName" => $media['ImageName'],
            "ImageServerPath"=>IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$type
        );*/  

        $updateData = array("MediaGUID" => $media['MediaGUID'], "ModuleID" => $module_id, "ModuleEntityGUID" => $entity_guid, 'ImageName' => $media['ImageName']);

        $return['Data']['ProfileCover'] = $this->updateProfileCover($updateData,$this->UserID);

        return $return;        
    }
    /**
     * Function Name : cropFile
     * Descript : This function will crop uploaded file
     */
    public function cropFile($FilePath,$FileName,$width,$height,$originalWidth=1920,$cropAxis=0,$resizePath,$dir_name='uploads',$axis_x=0,$CanResize=1,$CropHeight=280,$CropWidth=false,$originalHeight='auto',$r_height=0,$r_width=0){
        //print_r(func_get_args());
        $totalSize = 0;
        $this->load->library('image_lib');
        if($CanResize=='1' || $CanResize=='3'){
            $config['new_image']      = $FilePath.$resizePath;
            $config['image_library']  = 'gd2';
            $config['source_image']   = $FilePath.$FileName;
            $config['create_thumb']   = TRUE;
            $config['thumb_marker']   = '';
            $config['maintain_ratio'] = TRUE;
            $config['width']          = $originalWidth;
            $config['height']         = $height;
            $config['overwrite']       = TRUE;
            $this->image_lib->initialize($config); 
            $this->image_lib->resize();
        }

        $config = array();

        if($originalWidth<320 || $originalHeight<320 && $CanResize=='2'){
            $lpath = DOCUMENT_ROOT.SUBDIR.'/'.$FilePath.$width.'x'.$height.'/'.$FileName;
            copy(IMAGE_SERVER_PATH.$FilePath.$FileName,$lpath);
            $size = @filesize($lpath);
            if(isset($size) && !empty($size)) {
                $totalSize = $size;

            }
            return $totalSize;
        }

       // $cropAxis = ceil(($width/$originalWidth)*$cropAxis);
        $config['new_image']      = $FilePath.$resizePath;
        $config['image_library']  = 'gd2';
        if($CanResize=='1' || $CanResize=='3'){
            $config['source_image']   = $FilePath.$resizePath.$FileName;
        } else {
            $config['source_image']   = $FilePath.'/'.$FileName;   
        }
        $config['create_thumb']   = TRUE;
        $config['thumb_marker']   = '';
        $config['maintain_ratio'] = FALSE;
        if($CropHeight){
            $config['height']         = $CropHeight;
        }
        if($CropWidth){
            $config['width']         = $CropWidth;
        }
        $config['x_axis']         = $axis_x;
        $config['y_axis']         = $cropAxis;
        $this->image_lib->initialize($config); 
        if(!$this->image_lib->crop()){
            echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();

        if($CanResize == 1){
            $totalSize = $totalSize + $this->resizeImage($FilePath.ADMIN_THUMB_HEIGHT.'x'.ADMIN_THUMB_WIDTH.'/'.$FileName,$FilePath.$resizePath.$FileName,ADMIN_THUMB_HEIGHT,ADMIN_THUMB_WIDTH,FALSE);
        }

        $s3_path = $dir_name . "/".$resizePath.$FileName;
        if (strtolower(IMAGE_SERVER) == 'remote') {
            $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
            $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
        }
        $local_path = $FilePath.$resizePath.$FileName;
        $size = @filesize($local_path);
        if(isset($size) && !empty($size)) {
            $totalSize = $totalSize + ($size);

        }   
        if($CanResize == 2){
            sleep(1);
            $this->resizeImage($FilePath.$resizePath,$FilePath.$resizePath.$FileName,$height,$width);
        }

        if($CanResize == 3){
            sleep(1);
            $this->resizeImage($FilePath.$FileName,$FilePath.$resizePath.$FileName,$r_height,$r_width,FALSE);
        }

        return $totalSize;
    }

    public function cropProfilePicture($Data, $CanResize=2, $cropContainerWidth=320, $cropContainerHeight=320) {

        $Return['Message']      = lang('success');
        $Return['ResponseCode'] = 200;
        $Return['Data']         =array();

        $Type               = strtolower($Data['Type']);
        

        $ProfilePicture     = $Data['ProfilePicture'];
        $MediaGUID          = $Data['MediaGUID'];

        /*$DeviceType         = strtolower($Data['DeviceType']);
        $ModuleID           = $Data['ModuleID'];
        $EntityGUID         = $Data['ModuleEntityGUID'];
        $EntityID           = get_detail_by_guid($EntityGUID, $ModuleID);*/

        $Top                = $Data['Top'];
        $Left               = $Data['Left'];
        $SkipCropping       = isset($Data['SkipCropping']) ? $Data['SkipCropping'] : 0 ;  

        $dir_name   = PATH_IMG_UPLOAD_FOLDER . $Type;
        $chk_folder = PATH_IMG_UPLOAD_FOLDER;

        $folder_arr = $Type . '_folder';
        $thumb_arr  = $Type . '_thumb_size';
        $this->check_folder_exist($chk_folder, $this->$folder_arr);

        $FileDetails        = getimagesize(IMAGE_SERVER_PATH.$dir_name.'/'.$ProfilePicture);       
        
        $originalWidth      = $FileDetails[0];
        $originalHeight     = $FileDetails[1];
        
        $Left = $Left*-1;
        $Top = $Top*-1;

        $FilePath = $dir_name.'/';          
        
        $totalSize = 0;
        foreach ($this->$thumb_arr as $i => $row) {
            $w = $row[0];
            $h = $row[1];
            $totalSize = $totalSize + $this->cropFile($FilePath, $ProfilePicture, $w, $h, $originalWidth, $Top, $w.'x'.$h.'/', $dir_name, $Left, $CanResize,  $cropContainerWidth, $cropContainerHeight, $originalHeight);                
        }
        $this->db->set('Size','Size+'.$totalSize,FALSE);
        $this->db->where('MediaGUID',$MediaGUID);
        $this->db->update(MEDIA);
    }

    function resizeImage($NewImage,$SourceImage,$height,$width,$MaintainRatio=TRUE){
        $this->load->library('image_lib');
        $config['new_image']      = $NewImage;
        $config['image_library']  = 'gd2';
        $config['source_image']   = $SourceImage;
        $config['create_thumb']   = TRUE;
        $config['thumb_marker']   = '';
        $config['maintain_ratio'] = $MaintainRatio;
        $config['width']          = $height;
        $config['height']         = $width;
        $config['overwrite']       = TRUE;
        $this->image_lib->initialize($config); 
        $this->image_lib->resize();
        $this->image_lib->clear();
        
        $totalSize = 0;
        $size = @filesize($NewImage);
        if(isset($size) && !empty($size)) {
            $totalSize = $size;
        }
        if (strtolower(IMAGE_SERVER) == 'remote') {
            $s3_path = $NewImage;
            $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
            $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
            if($NewImage !== $SourceImage)
            {
                @unlink($s3_path);    
            }            
        }

        return $totalSize; //size in bytes
       // print_r($config);
    }

    /**
     * @Summary: check if folder exists otherwise create new
     * @create_date: 3 apr, 2013
     * @last_update_date:
     * @access: public
     * @param:
     * @return:
     */
    /**
     * [check_folder_exist check if folder exists otherwise create new]
     * @param  [string] $dir_name [Directroy name]
     * @param  array  $folder   [folder array]
     */
    public function check_folder_exist($dir_name, $folder = array()) {
        $d = ROOT_PATH . '/' . PATH_IMG_UPLOAD_FOLDER;
        if (!is_dir($d))
            mkdir($d, 0777);
        $d1 = ROOT_PATH . '/' . $dir_name;
        if (!is_dir($dir_name))
            mkdir($dir_name, 0777);

        foreach ($folder as $row) {
            if (!is_dir($dir_name . $row))
                mkdir($dir_name . $row, 0777);
        }
    }

    /**
     * [generate_thumb used to generate thumb]
     * @param  [string]  $temp_file      [Uploaded file temp path (full_path)]
     * @param  [string]  $dir_name       [Directroy name]
     * @param  [string]  $file_name      [Uploaded file name]
     * @param  array   $thumb          [Thumb Size array]
     * @param  array   $zc             [Array of zoom cropping option]
     * @param  integer $using_phpthumb [Use phpthumb library to generate thumb or not]
     * @param  string  $pathToFolder   [Upload folder path]
     * @param  string  $type           [section type on which file being uploading]
     */
    public function generate_thumb($temp_file, $dir_name, $file_name, $thumb = array(), $zc = array(), $using_phpthumb = 0,$pathToFolder='',$type='',$is_original=0) {
        $name_parts = pathinfo($file_name);
        $ext = strtolower($name_parts['extension']);
        $totalSize = 0;

       // if ($using_phpthumb == 1) {
        if($using_phpthumb==1)
        {
            $this->load->library('phpthumb');

            $temp_arr = explode('/',$temp_file);
            $temp_arr[count($temp_arr)-1] = 'org_'.$temp_arr[count($temp_arr)-1];
            $temp_file = implode('/',$temp_arr);

            list($width, $height) = @getimagesize($temp_file);
            //echo $width." ".$height;die;
            $size = @filesize($temp_file);

            $temp_file = file_get_contents($temp_file);
            
            foreach ($thumb as $i => $row) 
            {
                $w = $row[0];
                $h = $row[1];
                
                if($dir_name=='')
                {
                    $s3_path = $file_name;
                    $local_path = $file_name;
                } 
                else 
                {
                    if($is_original)
                    {
                        $s3_path = $dir_name . '/' . $file_name;
                        $local_path = DOCUMENT_ROOT . $pathToFolder . '/' . $dir_name . '/' . $file_name;
                    } 
                    else 
                    {
                        $s3_path = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                        $local_path = DOCUMENT_ROOT . $pathToFolder . '/' . $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                    }
                }

                if(($h==440 && $height < $h) || ($w==700 && $width < $w))
                {
                    $file_full_path = $dir_name.'/'.$file_name;
                    $destination_path = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;

                    if (strtolower(IMAGE_SERVER) == 'remote') 
                    {
                        $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);                        
                        if($s3->getObjectInfo(BUCKET, $file_full_path))
                        {
                            $res = $s3->copyObject(BUCKET, $file_full_path, BUCKET, $destination_path, S3::ACL_PUBLIC_READ);
                            $totalSize = $totalSize + ($size);
                        }
                    }
                    else
                    {
                        $file_location = ROOT_PATH. '/' .$dir_name.'/'.$file_name;
                        if(file_exists($file_location))
                        {
                            copy(IMAGE_SERVER_PATH.$file_full_path, $destination_path);
                            $totalSize = $totalSize + ($size);
                        }
                    }
                }
                else
                {
                    
                    $phpThumb = new phpThumb();
                    $phpThumb->resetObject();
                    $phpThumb->setSourceData($temp_file);
                    $phpThumb->setParameter('ar','x');
                    if($ext == 'png')
                    {
                        $phpThumb->setParameter('f','png');
                    }
                    if (isset($w))
                    {
                        $phpThumb->setParameter('w', $w);
                    }

                    if (isset($h))
                    {
                        $phpThumb->setParameter('h', $h);
                    }                

                    if ($zc[$i] == 1)
                    {
                        $phpThumb->setParameter('zc', true);
                    }

                    if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
                        if ($phpThumb->RenderToFile($local_path)) { //save file to destination
                            if (strtolower(IMAGE_SERVER) == 'remote') {
                                $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
                                $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
                            }
                        }
                    }

                    $size = @filesize($local_path);
                    if(isset($size) && !empty($size)) 
                    {
                        $totalSize = $totalSize + ($size);
                    }
                    if (strtolower(IMAGE_SERVER) == 'remote') {
                        @unlink($local_path);
                    }
                }                
            }
            // Generate thumb for original
            
        } else {
            $this->load->library('image_lib');
            foreach ($thumb as $row) {
                $w = $row[0];
                $h = $row[1];

                if($dir_name==''){
                    $s3_path = $file_name;
                    $local_path = $file_name;
                } else {
                    $s3_path = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                    $local_path = DOCUMENT_ROOT . $pathToFolder . '/' . $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                }
                /*echo $s3_path.'<br>'.$local_path.'<br>';
                if($dir_name==''){
                    $size = $file_name;
                } else {
                    $size = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                }*/
                
                
                $config = array();
// create thumb
                $config['image_library'] = 'GD2';
                $config['source_image'] = $temp_file;
                $config['new_image'] = $s3_path;
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = true;
                $config['width'] = $w;
                $config['height'] = $h;
                $this->image_lib->initialize($config);
                if ($this->image_lib->resize()) {
                    if (strtolower(IMAGE_SERVER) == 'remote') {
                        $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
                        $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
                        if (!$is_s3_upload) {
                            
                        }
                    }
                }
                $this->image_lib->clear();

                $size = @filesize($local_path);
                if(isset($size) && !empty($size)) {
                    $totalSize = $totalSize + ($size);

                }
            }
        }
       // echo $totalSize; die;
        return $totalSize;
    }
    
    /**
    * Function Name : saveMedia
    * @param 
    * Description: Save media 
    */
    function saveMedia($Media,$UserID=''){
        $this->db->insert(MEDIA,$Media);   
        $this->load->model('subscribe_model');
        $MediaID = $this->db->insert_id();
        if($UserID){
            $this->subscribe_model->toggle_subscribe($UserID,'Media',$MediaID); 
        }
        return $MediaID;    
    }

    /**
     * Function Name : getFileSize
     * @param
     * Description returns size of file in bytes
     */    
    function getFileSize($url){
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);

        $data = curl_exec($ch);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        curl_close($ch);
        return $size;
    }
    /**
     * [updateProfileCover used to update the profile cover image details for an entity]
     * @param  [array] $Data   [Image info]
     * @param  [int] $UserID [loggedin User ID]
     */
    function updateProfileCover($Data,$UserID){

        $ModuleID       = $Data['ModuleID'];
        $EntityGUID     = $Data['ModuleEntityGUID'];
        $EntityID       = get_detail_by_guid($EntityGUID, $ModuleID);
        $table_name     = USERS;
        $set_field      = "ProfileCover"; 
        $set_value      = $Data['ImageName'];
        $condition      = array("UserID" => $UserID);
        switch ($ModuleID) {  
            case '1':
                $table_name = GROUPS;
                $set_field  = "GroupCoverImage"; 
                $set_value  = $Data['ImageName'];
                $condition  = array("GroupID" => $EntityID);
                break;
            case '3':
                $table_name = USERS;
                $set_field  = "ProfileCover"; 
                $set_value  = $Data['ImageName'];
                $condition  = array("UserID" => $EntityID);
                break;    
            case '18':
                $table_name = PAGES;
                $set_field  = "CoverPicture"; 
                $set_value  = $Data['ImageName'];
                $condition  = array("PageID" => $EntityID);
                break;
            case '14':
                $table_name = EVENTS;
                $set_field  = "ProfileBannerID";
                $MediaID    = 0;
                $this->db->select("MediaID");
                $this->db->from(MEDIA);
                $this->db->where(array("MediaGUID" => $Data['MediaGUID']));
                $query = $this->db->get();
                if($query->num_rows()>0){
                    $result = $query->row_array();
                    $MediaID = $result['MediaID'];
                }
                $set_value  = $MediaID;
                $condition  = array("EventID" => $EntityID);
                break;      
            default:
                return FALSE;
                break;
        }

        $this->db->where($condition);
        $this->db->set($set_field, $set_value);       
        $this->db->update($table_name); 

        $Media[0]['MediaGUID'] = $Data['MediaGUID'];
        $Media[0]['Caption']   = '';
        $this->load->model('media/media_model');

        $AlbumID = get_album_id($UserID, DEFAULT_PROFILECOVER_ALBUM, $ModuleID, $EntityID);

        $this->media_model->updateMedia($Media, $EntityID, $UserID, $AlbumID);

        return IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.'profilebanner'.THUMB_profilebanner.$Data['ImageName'];
    }
    /**
     * [updateProfilePicture USED to update profile image info for an entity]
     * @param  [string] $MediaGUID        [MediaGUID]
     * @param  [string] $ProfilePicture   [Profile Picture Name]
     * @param  [int] $UserID              [Logged in user ID]
     * @param  [int] $ModuleID            [ModuleID]
     * @param  [string] $ModuleEntityGUID [Module Entity GUID]
     */
    function updateProfilePicture($MediaGUID,$ProfilePicture,$UserID,$ModuleID,$ModuleEntityGUID){
        $EntityID = get_detail_by_guid($ModuleEntityGUID,$ModuleID);
        switch ($ModuleID) {  
            case '1':
                $table_name = GROUPS;
                $set_field  = "GroupImage"; 
                $set_value  = $ProfilePicture;
                $condition  = array("GroupID" => $EntityID);
                break;
            case '3':
                $table_name = USERS;
                $set_field  = "ProfilePicture"; 
                $set_value  = $ProfilePicture;
                $condition  = array("UserID" => $EntityID);
                $this->session->set_userdata('ProfilePicture',$ProfilePicture);
                break;    
            case '18':
                $table_name = PAGES;
                $set_field  = "ProfilePicture"; 
                $set_value  = $ProfilePicture;
                $condition  = array("PageID" => $EntityID);
                break;
            case '14':
                $table_name = EVENTS;
                $set_field  = "ProfileImageID";
                $MediaID    = 0;
                $this->db->select("MediaID");
                $this->db->from(MEDIA);
                $this->db->where(array("MediaGUID" => $MediaGUID));
                $query = $this->db->get();
                if($query->num_rows()>0){
                    $result = $query->row_array();
                    $MediaID = $result['MediaID'];
                }
                $set_value  = $MediaID;
                $condition  = array("EventID" => $EntityID);
                break;      
            default:
                return FALSE;
                break;
        }

        $this->db->where($condition);
        $this->db->set($set_field, $set_value);       
        $this->db->update($table_name); 

        $Media[0]['MediaGUID'] = $MediaGUID;
        $Media[0]['Caption']   = '';
        $this->load->model('media/media_model');

        $AlbumID = get_album_id($UserID, DEFAULT_PROFILE_ALBUM, $ModuleID, $EntityID);
        $this->media_model->updateMedia($Media, $EntityID, $UserID, $AlbumID);
        return $ProfilePicture;
    }


    // Return MEdia Size ID
    function getMediaSizeID($size){
        $size = $size/1024; //convert byte into KB
        $query = $this->db->query("SELECT MediaSizeID FROM MediaSizes WHERE '".$size."' BETWEEN MinSize and MaxSize");
        if($query->num_rows()){
            return $query->row()->MediaSizeID;
        } else {
            return '1';
        }
    }

    public function removeProfileCover($UserID,$ModuleID,$ModuleEntityGUID){
       $EntityID = get_detail_by_guid($ModuleEntityGUID,$ModuleID);
       switch ($ModuleID) {  
            case '1':
                $table_name = GROUPS;
                $set_field  = "GroupCoverImage"; 
                $set_value  = "";
                $condition  = array("GroupID" => $EntityID);
                break;
            case '3':
                $table_name = USERS;
                $set_field  = "ProfileCover"; 
                $set_value  = "";
                $condition  = array("UserID" => $EntityID);
                break;    
            case '18':
                $table_name = PAGES;
                $set_field  = "CoverPicture"; 
                $set_value  = "";
                $condition  = array("PageID" => $EntityID);
                break;
            case '14':
                $table_name = EVENTS;
                $set_field  = "ProfileBannerID";
                $MediaID    = 0;
                $set_value  = 0;
                $condition  = array("EventID" => $EntityID);
                break;      
            default:
                return FALSE;
                break;
        }

        $this->db->where($condition);
        $this->db->set($set_field, $set_value);       
        $this->db->update($table_name); 
        return get_profile_cover('');
    }

    /**
     * [remove_profile_picture remove current profile picture]
     * @param  [type] $user_id           [User ID]
     * @param  [type] $module_id         [Module ID]
     * @param  [type] $module_entity_guid [Module Entity GUID]
     * @return [type]                   [description]
     */
    function remove_profile_picture($user_id, $module_id, $module_entity_guid){

       $entity_id = get_detail_by_guid($module_entity_guid,$module_id);
       switch ($module_id) {  
            case '1':
                $table_name = GROUPS;
                $set_field  = "GroupImage"; 
                $set_value  = "";
                $condition  = array("GroupID" => $entity_id);
                $compare    = "ImageName";
                break;
            case '3':
                $table_name = USERS;
                $set_field  = "ProfilePicture"; 
                $set_value  = "";
                $condition  = array("UserID" => $entity_id);
                $this->session->set_userdata('ProfilePicture','');
                $compare    = "ImageName";
                break;    
            case '18':
                $table_name = PAGES;
                $set_field  = "ProfilePicture"; 
                $set_value  = "";
                $condition  = array("PageID" => $entity_id);
                $compare    = "ImageName";
                break;
            case '14':
                $table_name = EVENTS;
                $set_field  = "ProfileImageID";
                $MediaID    = 0;
                $set_value  = 0;
                $condition  = array("EventID" => $entity_id);
                $compare    = "MediaID";
                break;      
            default:
                return FALSE;
                break;
        }

        $this->db->select($set_field);
        $this->db->from($table_name);
        $this->db->where($condition);
        $query = $this->db->get();
        $value = $query->row()->$set_field;

        /*$this->db->set('StatusID','3');
        $this->db->where($compare,$value);
        $this->db->update(MEDIA);*/

        $this->db->where($condition);
        $this->db->set($set_field, $set_value);       
        $this->db->update($table_name); 
        return '';
    }
    /**
     * [delete_media_file used to delete media files and all its thumbnail]
     * @param  [string] $file_name [file name]
     * @param  [string] $type      [section type like profile, profile banner]
     */
    function delete_media_file($file_name, $type) {
        
        $thumb_arr  = $type . '_thumb_size';
        $dir_name   = IMAGE_ROOT_PATH . $type;
        //echo $dir_name.'/'.$file_name;die;
        if(!empty($file_name) && file_exists($dir_name.'/'.$file_name)) {
           
            unlink($dir_name.'/'.$file_name);

            foreach ($this->$thumb_arr as $i => $row) {
                $w = $row[0];
                $h = $row[1];
                $thumb_file_name = $w.'x'.$h.'/'.$file_name;
                if(file_exists($dir_name.'/'.$thumb_file_name)) {
                    unlink($dir_name.'/'.$thumb_file_name);
                }
            }
        }
    }

    /**
     * [delete_media description]
     * @param  [int]  $MediaID [Media ID]
     * @param  boolean $Flag    [false means hard delete, true means soft delete]
     */
    function delete_media($MediaID, $Flag=false) {
        $this->db->select('M.ImageName', FALSE);
        $this->db->select('M.StatusID', FALSE);
        $this->db->select('M.MediaSectionID', FALSE);
        $this->db->select('MS.MediaSectionAlias', FALSE);

        $this->db->join(MEDIASECTIONS . " AS MS", ' MS.MediaSectionID = M.MediaSectionID', 'right');
        $this->db->from(MEDIA . " AS M");
        $this->db->where('M.MediaID', $MediaID);
        $query = $this->db->get();        
        if($query->num_rows()) {
            $row                = $query->row();
            $ImageName     = $row->ImageName;
            $MediaSectionAlias  = $row->MediaSectionAlias;
            $this->db->where('MediaID',$MediaID);
            if($Flag) {
                $this->db->set('StatusID', '3',FALSE);
                $this->db->update(MEDIA);
            } else {
                $this->db->delete(MEDIA);
                if(!empty($ImageName) && !empty($MediaSectionAlias)) {
                    $this->delete_media_file($ImageName, $MediaSectionAlias);
                }                      
            }
        }
    }

       /**
     * Function Name: checkMediaCounts
     * @param paramArray[],updateFlag
     * Description: check and update media analytics count
     */
    function checkMediaCounts($paramArray = array(), $updateFlag = false) {
        $where = 'StatusID != 3';

        $selectFromArray = array();
        $whereFromArray = array();

        $select = 'COUNT(CASE WHEN IsAdminApproved = 1 then 1 ELSE NULL END) as admin_approved, COUNT(CASE WHEN IsAdminApproved = 0 then 1 ELSE NULL END) as admin_yet_to_approve';

        if (isset($paramArray['DeviceID'])) {
            $selectFromArray['selectForDeviceID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND DeviceID=' . $paramArray['DeviceID'] . ') then 1 ELSE NULL END) as admin_approved_for_device, COUNT(CASE WHEN (IsAdminApproved = 0 AND DeviceID=' . $paramArray['DeviceID'] . ') then 1 ELSE NULL END) as admin_yet_to_approve_for_device';
            $whereFromArray['DeviceID'] = $paramArray['DeviceID'];

            /* filter by user */
            if (isset($paramArray['UserID'])) {
                $selectFromArray['filterForDeviceID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND DeviceID=' . $paramArray['DeviceID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_approved_for_device, COUNT(CASE WHEN (IsAdminApproved = 0 AND DeviceID=' . $paramArray['DeviceID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_yet_to_approve_for_device';
            }
            /* end filter by user */
        }

        if (isset($paramArray['SourceID'])) {
            $selectFromArray['selectForSourceID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND SourceID=' . $paramArray['SourceID'] . ') then 1 ELSE NULL END) as admin_approved_for_source, COUNT(CASE WHEN (IsAdminApproved = 0 AND SourceID=' . $paramArray['SourceID'] . ') then 1 ELSE NULL END) as admin_yet_to_approve_for_source';
            $whereFromArray['SourceID'] = $paramArray['SourceID'];

            /* filter by user */
            if (isset($paramArray['UserID'])) {
                $selectFromArray['filterForSourceID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND SourceID=' . $paramArray['SourceID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_approved_for_source, COUNT(CASE WHEN (IsAdminApproved = 0 AND SourceID=' . $paramArray['SourceID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_yet_to_approve_for_source';
            }
            /* end filter by user */
        }

        if (isset($paramArray['MediaExtensionID'])) {
            $selectFromArray['selectForMediaExtensionID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND MediaExtensionID=' . $paramArray['MediaExtensionID'] . ') then 1 ELSE NULL END) as admin_approved_for_mediaext, COUNT(CASE WHEN (IsAdminApproved = 0 AND MediaExtensionID=' . $paramArray['MediaExtensionID'] . ') then 1 ELSE NULL END) as admin_yet_to_approve_for_mediaext';
            $whereFromArray['MediaExtensionID'] = $paramArray['MediaExtensionID'];

            /* filter by user */
            if (isset($paramArray['UserID'])) {
                $selectFromArray['filterForMediaExtensionID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND MediaExtensionID=' . $paramArray['MediaExtensionID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_approved_for_mediaext, COUNT(CASE WHEN (IsAdminApproved = 0 AND MediaExtensionID=' . $paramArray['MediaExtensionID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_yet_to_approve_for_mediaext';
            }
            /* end filter by user */
        }

        if (isset($paramArray['MediaSectionID'])) {
            $selectFromArray['selectForMediaSectionID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND MediaSectionID=' . $paramArray['MediaSectionID'] . ') then 1 ELSE NULL END) as admin_approved_for_media_sec_ref, COUNT(CASE WHEN (IsAdminApproved = 0 AND MediaSectionID=' . $paramArray['MediaSectionID'] . ') then 1 ELSE NULL END) as admin_yet_to_approve_for_media_sec_ref';
            $whereFromArray['MediaSectionID'] = $paramArray['MediaSectionID'];

            /* filter by user */
            if (isset($paramArray['UserID'])) {
                $selectFromArray['filterForMediaSectionID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND MediaSectionID=' . $paramArray['MediaSectionID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_approved_for_media_sec_ref, COUNT(CASE WHEN (IsAdminApproved = 0 AND MediaSectionID=' . $paramArray['MediaSectionID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_yet_to_approve_for_media_sec_ref';
            }
            /* end filter by user */
        }

        if (isset($paramArray['MediaSizeID'])) {
            $selectFromArray['selectForMediaSizeID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND MediaSizeID=' . $paramArray['MediaSizeID'] . ') then 1 ELSE NULL END) as admin_approved_for_media_size, COUNT(CASE WHEN (IsAdminApproved = 0 AND MediaSizeID=' . $paramArray['MediaSizeID'] . ') then 1 ELSE NULL END) as admin_yet_to_approve_for_media_size';
            $whereFromArray['MediaSizeID'] = $paramArray['MediaSizeID'];

            /* filter by user */
            if (isset($paramArray['UserID'])) {
                $selectFromArray['filterForMediaSizeID'] = 'COUNT(CASE WHEN (IsAdminApproved = 1 AND MediaSizeID=' . $paramArray['MediaSizeID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_approved_for_media_size, COUNT(CASE WHEN (IsAdminApproved = 0 AND MediaSizeID=' . $paramArray['MediaSizeID'] . ' AND UserID=' . $paramArray['UserID'] . ') then 1 ELSE NULL END) as filter_admin_yet_to_approve_for_media_size';
            }
            /* end filter by user */
        }


        if (!empty($selectFromArray)) {
            $select = '';
            foreach ($selectFromArray as $key => $val) {
                if ($select != '')
                    $select .= ', ';

                $select .= $val;
            }

            if (!empty($whereFromArray)) {
                $tempWhere = '';
                foreach ($whereFromArray as $key => $val) {
                    if ($tempWhere != '')
                        $tempWhere .= ' OR ';

                    $tempWhere .= $key . '=' . $val;
                }
                $where .= ' AND (' . $tempWhere . ')';
            }
        }


        $this->db->select($select);
        $this->db->from(MEDIA);

        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get();
        $dataArray = $query->row_array();
        /* update media count */
        if ($updateFlag) {
            foreach ($paramArray as $key => $val) {
                if ($key == 'DeviceID') {/* update MediaDeviceCounts */
                    $insertUpdateArray = array(
                        'table' => MEDIADEVICECOUNTS,
                        'where' => array('colName' => 'DeviceTypeID', 'val' => $val),
                        'data' => array('ApproveCount' => $dataArray['admin_approved_for_device'], 'YetToApproveCount' => $dataArray['admin_yet_to_approve_for_device'])
                    );
                    $this->insertUpdate($insertUpdateArray);
                } elseif ($key == 'SourceID') {/* update MediaSourceCount */
                    $insertUpdateArray = array(
                        'table' => MEDIASOURCECOUNT,
                        'where' => array('colName' => 'SourceID', 'val' => $val),
                        'data' => array('ApproveCount' => $dataArray['admin_approved_for_source'], 'YetToApproveCount' => $dataArray['admin_yet_to_approve_for_source'])
                    );
                    $this->insertUpdate($insertUpdateArray);
                } elseif ($key == 'MediaExtensionID') {/* update MediaExtensionCount */
                    $insertUpdateArray = array(
                        'table' => MEDIAEXTENSIONCOUNT,
                        'where' => array('colName' => 'MediaExtensionID', 'val' => $val),
                        'data' => array('ApproveCount' => $dataArray['admin_approved_for_mediaext'], 'YetToApproveCount' => $dataArray['admin_yet_to_approve_for_mediaext'])
                    );
                    $this->insertUpdate($insertUpdateArray);
                } elseif ($key == 'MediaSectionID') {/* update MediaSectionCount */
                    $insertUpdateArray = array(
                        'table' => MEDIASECTIONCOUNT,
                        'where' => array('colName' => 'MediaSectionID', 'val' => $val),
                        'data' => array('ApproveCount' => $dataArray['admin_approved_for_media_sec_ref'], 'YetToApproveCount' => $dataArray['admin_yet_to_approve_for_media_sec_ref'])
                    );
                    $this->insertUpdate($insertUpdateArray);
                } elseif ($key == 'MediaSizeID') {/* update MediaSizeCounts */
                    $insertUpdateArray = array(
                        'table' => MEDIASIZECOUNTS,
                        'where' => array('colName' => 'MediaSizeID', 'val' => $val),
                        'data' => array('ApproveCount' => $dataArray['admin_approved_for_media_size'], 'YetToApproveCount' => $dataArray['admin_yet_to_approve_for_media_size'])
                    );
                    $this->insertUpdate($insertUpdateArray);
                }
            }
        }
    }

    /**
     * Function Name: insertUpdate
     * @param data[]
     * Description: insert/update row
     */
    function insertUpdate($data = array()) {
        $this->db->select($data['where']['colName']);
        $this->db->where(array($data['where']['colName'] => $data['where']['val']));
        $this->db->from($data['table']);
        $this->db->limit(1);
        $query = $this->db->get();
        $resArray = $query->row_array();
        if (!empty($resArray)) {/* update */
            $this->db->where(array($data['where']['colName'] => $data['where']['val']));
            $this->db->update($data['table'], $data['data']);
        } else {/* insert */
            $insertArray = array_merge($data['data'], array($data['where']['colName'] => $data['where']['val']));
            $this->db->insert($data['table'], $insertArray);
        }
    }
    
    /**
     * [uploadVideo Used to upload video file]
     * @param [type] $Data [input data for upload file Request]
     * @return [Object] [json object]
     */
    function uploadVideo($Data, $generateThumb=1)
    {

        $Return['Message'] = lang('success');
        $Return['ResponseCode'] = 200;
        $Return['Data'] = array();

        $Type = strtolower($Data['Type']);
        $DeviceType = strtolower($Data['DeviceType']);

        $ModuleID = isset($Data['ModuleID']) ? $Data['ModuleID'] : 0;
        $EntityGUID = isset($Data['ModuleEntityGUID']) ? $Data['ModuleEntityGUID'] : 0;
        $EntityID = 0;
        if ($EntityGUID && $ModuleID)
        {
            $EntityID = get_detail_by_guid($EntityGUID, $ModuleID);
        }

        $folder_arr = $Type . '_folder';
        //$dir_name = PATH_VID_UPLOAD_FOLDER . $Type;

        $dir_name   = PATH_IMG_UPLOAD_FOLDER . $Type;

        $this->check_video_folder_exist($dir_name);

        $config['upload_path'] = $dir_name . "/";
        $config['allowed_types'] = $this->allowed_video_types;
        $config['max_size'] = $this->allowed_video_max_size;
        /* $config['max_width']        = $this->allowed_image_max_width;
          $config['max_height']       = $this->allowed_image_max_height; */
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('qqfile'))
        {
            $Return['ResponseCode'] = 511;
            $Errors = $this->upload->error_msg;

            if (!empty($Errors))
            {
                $Return['Message'] = $Errors['0']; // first message
            } else
            {
                $Return['Message'] = "Unable to fetch error code."; // first message
            }
            return $Return;
            //Shows all error messages as a string              
        } else
        {
            $UploadData = $this->upload->data();

            $totalSize = 0;
            $JobID = NULL;
            if (strtolower(IMAGE_SERVER) == 'remote')
            {
                $s3_path = $dir_name . '/' . $UploadData['file_name'];
                $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
                $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ);
                $JobID = $this->zencoder_create_job($s3_path);
                //echo $JobID;
            }else{
                $this->create_video_thumb($UploadData);
            }
            
            $image_type = strtolower($UploadData['file_ext']);
            $image_type = trim($image_type, '.');
            $MediaSectionID = isset($this->MediaSectionIDArray[$Type]) ? $this->MediaSectionIDArray[$Type] : 1;
            $DeviceID = $this->DeviceTypeID;
            if (empty($DeviceID))
            {
                $DeviceID = isset($this->DeviceTypeIDArray[$DeviceType]) ? $this->DeviceTypeIDArray[$DeviceType] : 1;
            }
            $MediaExtensionID = isset($this->MediaExtensionIDArray[$image_type]) ? $this->MediaExtensionIDArray[$image_type] : 1;
            //echo print_r($UploadData);print_r($this->MediaExtensionIDArray);die;
            $totalSize = $UploadData['file_size'] + $totalSize;
            $Media = array(
                'MediaGUID' => get_guid(),
                'UserID' => $this->UserID,
                'MediaSectionID' => $MediaSectionID,
                'OriginalName'      => $UploadData['orig_name'],
                'ModuleID' => $ModuleID,
                'ModuleEntityID' => $EntityID,
                'ImageName' => $UploadData['file_name'],
                'ImageUrl' => $UploadData['file_name'],
                'Size' => $totalSize, //The file size in kilobytes
                'DeviceID' => $DeviceID,
                'SourceID' => $this->SourceID,
                'MediaExtensionID' => $MediaExtensionID,
                'MediaSectionReferenceID' => 0,
                'CreatedDate' => get_current_date('%Y-%m-%d %H:%i:%s'),
                'StatusID' => 1, // default pending
                'IsAdminApproved' => 1,
                'AbuseCount' => 0,
                'AlbumID' => 0,
                'Caption' => "",
                'MediaSizeID' => $this->getMediaSizeID($totalSize),
                'ConversionStatus' => 'Pending',
                'JobID' => $JobID
            );

            $this->saveMedia($Media,$this->UserID);
            $this->checkMediaCounts($Media, true);
            //insert in to media table with status pending which means in 24 hours this file will be deleted from server.
            //MediaGUID, MediaName
            $Return['Data'] = array(
                "MediaGUID" => $Media['MediaGUID'],
                "ImageName" => $Media['ImageName'],
                "FileName"  => pathinfo($Media['ImageName'], PATHINFO_FILENAME),
                "OriginalName" => $Media['OriginalName'],
                "ImageServerPath"=>IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$Type,
                "MediaType"=>'VIDEO',
                "MediaSectionAlias"=>($MediaSectionID==4?'album':'')
            );
        }
        return $Return;
    }

    /**
     * @Summary: check if folder exists otherwise create new
     * @create_date: 3 apr, 2013
     * @last_update_date:
     * @access: public
     * @param:
     * @return:
     */

    /**
     * [check_folder_exist check if folder exists otherwise create new]
     * @param  [string] $dir_name [Directroy name]
     * @param  array  $folder   [folder array]
     */
    public function check_video_folder_exist($dir_name)
    {
        $d = ROOT_PATH . '/' . $dir_name;
        if (!is_dir($d))
        {
            mkdir($d, 0777, TRUE);
        }
    }

    public function create_video_thumb($video)
    {
        //print_r($video);die;
        // where ffmpeg is located  
        $ffmpeg = '/usr/bin/ffmpeg';
        //video dir  
        $videofile = $video['full_path'];
        //where to save the image  
        if (!is_dir($video['file_path'].'220x220/'))
        {
            mkdir($video['file_path'].'220x220/', 0777, TRUE);
        }
        //$image = $video['file_path'].'220x220/'.$video['file_name'].'.png';
        
        $image = $video['file_path'].'220x220/'.pathinfo($video['file_name'], PATHINFO_FILENAME).'.jpg';
        //time to take screenshot at  
        $interval = 105;
        //screenshot size  
        $size = '220x220';
        //ffmpeg command  
        //echo $ffmpeg;
        $cmd = "$ffmpeg -itsoffset -4 -i $videofile -vcodec png -vframes 1 -an -f rawvideo -s $size -y $image";
        //$cmd = "$ffmpeg -i $videofile -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y -s $size $image";
        //exec($cmd);
        //echo $cmd;
        shell_exec($cmd);
    }
    
    function zencoder_create_job($video_url = '')
    {
        if($video_url==''){
            return FALSE;
        }

        $this->load->library('Services_Zencoder'); // load library

        $name_parts = pathinfo($video_url);
        $notify_url = base_url('/cron/zencoder_notification') ;
        $base_url   = $name_parts['dirname'];
        $imgb_url   = $name_parts['dirname'].'/220x220';
        $imgb_url1   = $name_parts['dirname'].'/700x440';
        $imgb_url2   = $name_parts['dirname'].'/'.ADMIN_THUMB_WIDTH."x".ADMIN_THUMB_HEIGHT;

        $input_url  = "s3://".BUCKET."/" . $video_url;

        $new_url1    = $base_url . '/' . $name_parts['filename'] . ".ogg";
        $output_url1 = "s3://".BUCKET."/" . $new_url1;

        $new_url2    = $base_url . '/' . $name_parts['filename'] . ".webm";
        $output_url2 = "s3://".BUCKET."/" . $new_url2;


        $new_url4    = $base_url . '/' . $name_parts['filename'] . ".mp4";
        $output_url4 = "s3://".BUCKET."/" . $new_url4;

        try {

            // Initialize the Services_Zencoder class
            $zencoder     = new Services_Zencoder(ZENCODER_API_KEY);
            // New Encoding Job
            $encoding_job = $zencoder->jobs->create(array(
                "input" => $input_url,
                "notifications"=>array($notify_url),
                "outputs" => array(
                    array   (
                        "label" => "ogv",
                        "url" => $output_url1,
                        "public" => true,
                        "thumbnails" => array(array(
                                "label" => "poster",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => "220x220",
                                "aspect_mode" => "crop"
                        ),
                        array(
                                "label" => "second",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url1 . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => "700x440",
                                "aspect_mode" => "crop"
                        ),
                        array(
                                "label" => "adthumb",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url2 . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => ADMIN_THUMB_WIDTH."x".ADMIN_THUMB_HEIGHT,
                                "aspect_mode" => "crop"
                        ))
                    ),
                     array   (
                        "label" => "webm",
                        "url" => $output_url2,
                        "public" => true,
                        "thumbnails" => array(array(
                                "label" => "poster",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => "220x220",
                                "aspect_mode" => "crop"
                        ),
                        array(
                                "label" => "second",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url1 . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => "700x440",
                                "aspect_mode" => "crop"
                        ),
                        array(
                                "label" => "adthumb",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url2 . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => ADMIN_THUMB_WIDTH."x".ADMIN_THUMB_HEIGHT,
                                "aspect_mode" => "crop"
                        ))
                    ),
                     array   (
                        "label" => "mp4",
                        "url" => $output_url4,
                        "public" => true,
                        "thumbnails" => array(array(
                                "label" => "poster",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => "220x220",
                                "aspect_mode" => "crop"
                        ),
                        array(
                                "label" => "second",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url1 . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => "700x440",
                                "aspect_mode" => "crop"
                        ),
                        array(
                                "label" => "adthumb",
                                "base_url" => "s3://".BUCKET."/" . $imgb_url2 . "/",
                                "public" => true,
                                "number" => 1,
                                "filename" => $name_parts['filename'],
                                "format" => "jpg",
                                "size" => ADMIN_THUMB_WIDTH."x".ADMIN_THUMB_HEIGHT,
                                "aspect_mode" => "crop"
                        ))
                    )
                )
            ));
            return $encoding_job->id;
            // Success if we got here
            //echo "w00t! \n\n";
            //echo "Job ID: ".$encoding_job->id."\n";
           // echo "Output ID: ".$encoding_job->outputs['web']->id."\n";
            // Store Job/Output IDs to update their status when notified or to check their progress.
        }
        catch (Services_Zencoder_Exception $e) {
            //print_r($e->getErrors());die;
            //$ip         = $this->input->ip_address();
            //$users_data = array(
            //    'ip_address' => $ip,
            //    'user_id' => $this->auth->userid(),
            //   'description' => serialize($e->getErrors()),
            //    'record_type' => 'ZENCODER_ERROR'
            //);
            //$this->asset_log($users_data);
            // If were here, an error occured
            //echo "Fail :(\n\n";
            // echo "Errors:\n";
            // foreach ($e->getErrors() as $error) echo $error."\n";
            //  echo "Full exception dump:\n\n";
            //print_r($e);

            $data = array(
                'error' => 'Zencode API ERROR',
                'result' => 'error',
                'file_path' => $video_url,
                'file_name' => $name_parts['filename'],
                'reason' => serialize($e->getErrors())
            );
            return FALSE;
        }
        // Catch notification
        //echo "\nAll Job Attributes:\n";
        //var_dump($encoding_job);
    }

    public function zencoder_notification()
    {
        $data = file_get_contents('php://input');
        //write_file(APPPATH . 'logs/zencoder.txt', $data, 'a');
        $job = json_decode($data, TRUE);

        if (isset($job['job']['id']) && !empty($job['job']['id']))
        {
            $job_id = $job['job']['id'];
             
            $duration_in_ms   = !empty($job['input']['duration_in_ms'])?$job['input']['duration_in_ms']:0;
            $input_file_size   = !empty($job['input']['file_size_in_bytes'])?$job['input']['file_size_in_bytes']:0;
            $state      = !empty($job['job']['state'])?ucfirst($job['job']['state']):'';

            if(!empty($duration_in_ms) && $state=='Finished')
            {
                $this->db->select('MediaID,ImageName,MediaSectionID,MediaSectionReferenceID');
                $this->db->from(MEDIA.' AS M');
                $this->db->JOIN(MEDIAEXTENSIONS.' AS ME','M.MediaExtensionID=ME.MediaExtensionID');
                $this->db->JOIN(MEDIATYPES.' AS MT','MT.MediaTypeID=ME.MediaTypeID');
                $this->db->where('MT.MediaTypeID',2);
                $this->db->where('M.ConversionStatus','Pending');
                $this->db->where('M.JobID',$job_id);    
                $query = $this->db->get();
                //echo $query->num_rows();

                $output_file_size = 0;
                $same_ext = 0;
                if($query->num_rows())
                {
                    $row = $query->row_array();
                    $image_name = $row['ImageName'];
                    $extension = explode('.', $image_name);
                    $extension = end($extension);
                    $extension = strtolower($extension);

                    if (isset($job['outputs']) && !empty($job['outputs']))
                    {
                        $outputs = $job['outputs']; 
                        foreach($outputs as $output)
                        {
                            $label = isset($output['label'])?strtolower($output['label']):'';
                            $output_file_size = $output_file_size + isset($output['file_size_in_bytes'])?$output['file_size_in_bytes']:0;
                            if($extension==$label)
                            {
                                $same_ext = 1;
                            }
                        }
                    }                    
                    if(empty($same_ext))
                    {
                        $output_file_size = $output_file_size + $input_file_size;    
                    }

                    if($row['MediaSectionID'] == 3 && $state == 'Finished')
                    {
                        $this->load->model('activity/activity_model');
                        $row = $this->activity_model->activate_activity($row['MediaSectionReferenceID']);
                        
                        $this->notification_model->add_notification(82,$row['UserID'],array($row['UserID']),$row['ActivityID'],array(),true,1);
                    }
                }

                $this->db->where('JobID',$job_id);
                $this->db->update(MEDIA,array('VideoLength'=>$duration_in_ms, 'ConversionStatus'=>$state, 'Size'=>$output_file_size));

                //echo "<br>".$this->db->last_query();
            }
            echo "Success!\n";
        }elseif ($state == "cancelled") {
           echo "Cancelled!\n";
        } else {
           echo "Fail!\n";
        }
    }

    function create_cover_thumb($file_name,$width=200,$height=200)
    {
        $s3         = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
        $this->load->library('phpthumb'); 

        $w = $width;
        $h = $height;

        $MediaSectionAlias = 'profilebanner';

        $file_full_path = IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.'/1200x200/'.$file_name;

        $dir_name   = PATH_IMG_UPLOAD_FOLDER . $MediaSectionAlias;

        $folder_arr = array($MediaSectionAlias."/".$w."x".$h);

        $this->check_folder_exist(PATH_IMG_UPLOAD_FOLDER, $folder_arr);

        $name_parts = pathinfo($file_name);
        $ext = strtolower($name_parts['extension']);
        $totalSize = 0;
        
        $temp_file = file_get_contents($file_full_path);

        $phpThumb = new phpThumb();
        $phpThumb->resetObject();
        $phpThumb->setSourceData($temp_file);
        $phpThumb->setParameter('ar','x');
        if($ext == 'png')
        {
            $phpThumb->setParameter('f','png');
        }
        if (isset($w))
        {
            $phpThumb->setParameter('w', $w);
        }
        if (isset($h))
        {
            $phpThumb->setParameter('h', $h);
        }
        
        $s3_path = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
        $local_path = DOCUMENT_ROOT . $this->pathToFolder . '/' . $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;

        $phpThumb->setParameter('zc', true);

        if ($phpThumb->GenerateThumbnail()) 
        { // this line is VERY important, do not remove it!
            if ($phpThumb->RenderToFile($local_path)) 
            { //save file to destination
                if (strtolower(IMAGE_SERVER) == 'remote') 
                {
                    //$s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
                    $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
                }
            }
        }

        /*$lpath = DOCUMENT_ROOT.SUBDIR.'/'.$FilePath.$width.'x'.$height.'/'.$FileName;
            copy(IMAGE_SERVER_PATH.$FilePath.$FileName,$lpath);*/
        $size = @filesize($local_path);
        if(isset($size) && !empty($size)) {
            $totalSize = $size;
        }
            

        if (strtolower(IMAGE_SERVER) == 'remote') 
        {
            @unlink($local_path);
        }
        return $totalSize;
    }

    function create_image_thumb($media_section_id, $page_no=1, $page_size=30) 
    {
        
        $this->db->select('M.MediaID, M.ImageName, MT.Name as MediaType, M.MediaSectionID, MS.MediaSectionAlias', FALSE);        
        $this->db->join(MEDIAEXTENSIONS . ' ME', 'ME.MediaExtensionID=M.MediaExtensionID', 'LEFT');
        $this->db->join(MEDIASECTIONS . ' MS', 'MS.MediaSectionID=M.MediaSectionID', 'LEFT');
        $this->db->join(MEDIATYPES . ' MT', 'MT.MediaTypeID=ME.MediaTypeID', 'LEFT');
        $this->db->where('M.MediaSectionID', $media_section_id);
        $this->db->where('ME.MediaTypeID', 1);
        $this->db->order_by('M.MediaID','DESC');
        
        $offset = ($page_no-1)*$page_size;    
        $this->db->limit($page_size, $offset);

        $query  = $this->db->get(MEDIA . ' M');

       // echo $this->db->last_query();die;
        if($query->num_rows())
        {
            $s3         = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
            $this->load->library('phpthumb'); 
            $i = 0;
            foreach($query->result_array() as $img) 
            {
                ++$i;
                $exist              = FALSE;                
                $MediaID            = $img['MediaID'];
                $MediaType          = $img['MediaType'];
                $MediaSectionID     = $img['MediaSectionID'];
                $MediaSectionAlias  = $img['MediaSectionAlias'];
                $file_name          = $img['ImageName'];          
                $SubDir             = "/";
                $file_full_path     = "";
                                
                if(!empty($img))
                {
                    $file_full_path = PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.$file_name;
                    if(strtolower(IMAGE_SERVER) == 'remote')
                    {
                        if($s3->getObjectInfo(BUCKET, $file_full_path))
                        {
                           $exist = TRUE; 
                           $file_full_path = IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.'org_'.$file_name;
                        }
                        elseif($s3->getObjectInfo(BUCKET, PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.$file_name))
                        {
                            $exist = TRUE; 
                            $file_full_path = IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.$file_name;        
                        }
                    } 
                    else 
                    {
                        $file_full_path = IMAGE_ROOT_PATH.$MediaSectionAlias.$SubDir.'org_'.$file_name; 
                        if(file_exists($file_full_path))
                        {                            
                            $exist = TRUE;    
                        }
                        else if(file_exists(IMAGE_ROOT_PATH.$MediaSectionAlias.$SubDir.$file_name))
                        {
                            $file_full_path = IMAGE_ROOT_PATH.$MediaSectionAlias.$SubDir.$file_name;
                            $exist = TRUE;    
                        } 
                    }                            
                }
                echo "<br> $i. ".$file_full_path;
                if($exist)
                {
                    $dir_name   = PATH_IMG_UPLOAD_FOLDER . $MediaSectionAlias;

                    $folder_arr = array($MediaSectionAlias."/370x300");

                    $this->check_folder_exist(PATH_IMG_UPLOAD_FOLDER, $folder_arr);

                    $name_parts = pathinfo($file_name);
                    $ext = strtolower($name_parts['extension']);
                    $totalSize = 0;
                    
                    $temp_file = file_get_contents($file_full_path);
            
                    $w = 370;
                    $h = 300;
                    $phpThumb = new phpThumb();
                    $phpThumb->resetObject();
                    $phpThumb->setSourceData($temp_file);
                    $phpThumb->setParameter('ar','x');
                    if($ext == 'png')
                    {
                        $phpThumb->setParameter('f','png');
                    }
                    if (isset($w))
                    {
                        $phpThumb->setParameter('w', $w);
                    }
                    if (isset($h))
                    {
                        $phpThumb->setParameter('h', $h);
                    }
                    
                    $s3_path = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                    $local_path = DOCUMENT_ROOT . $this->pathToFolder . '/' . $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;

                    $phpThumb->setParameter('zc', true);

                    if ($phpThumb->GenerateThumbnail()) 
                    { // this line is VERY important, do not remove it!
                        if ($phpThumb->RenderToFile($local_path)) 
                        { //save file to destination
                            if (strtolower(IMAGE_SERVER) == 'remote') 
                            {
                                //$s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
                                $is_s3_upload = $s3->putObjectFile($s3_path, BUCKET, $s3_path, S3::ACL_PUBLIC_READ, $this->headers);
                            }
                        }
                    }

                    if (strtolower(IMAGE_SERVER) == 'remote') 
                    {
                        @unlink($local_path);
                    } 
                }               
            }
        }
    }

    function copy_video_thumb($media_section_id, $page_no=1, $page_size=30) 
    {
        $this->db->select('M.MediaID, M.ImageName, MT.Name as MediaType, M.MediaSectionID, MS.MediaSectionAlias', FALSE);        
        $this->db->join(MEDIAEXTENSIONS . ' ME', 'ME.MediaExtensionID=M.MediaExtensionID', 'LEFT');
        $this->db->join(MEDIASECTIONS . ' MS', 'MS.MediaSectionID=M.MediaSectionID', 'LEFT');
        $this->db->join(MEDIATYPES . ' MT', 'MT.MediaTypeID=ME.MediaTypeID', 'LEFT');
        $this->db->where('M.MediaSectionID', $media_section_id);
        $this->db->where('ME.MediaTypeID', 2);
        //$this->db->where('M.UserID','5');
        $this->db->order_by('M.MediaID','DESC');
        
        $offset = ($page_no-1)*$page_size;    
        $this->db->limit($page_size, $offset);

        $query  = $this->db->get(MEDIA . ' M');

        //echo $this->db->last_query();die;
        if($query->num_rows())
        {
            $s3         = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);           
            $i = 0;
            foreach($query->result_array() as $img) 
            {
                ++$i;
                $exist              = FALSE;                
                $MediaID            = $img['MediaID'];
                $MediaType          = $img['MediaType'];
                $MediaSectionID     = $img['MediaSectionID'];
                $MediaSectionAlias  = $img['MediaSectionAlias'];
                $file_name          = $img['ImageName'];          
                $SubDir             = "/";
                $file_full_path     = "";
                $file_location      = "";
                                
                if(!empty($img))
                {
                    $file_full_path = PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.$file_name;
                    if(strtolower(IMAGE_SERVER) == 'remote')
                    {
                        if($s3->getObjectInfo(BUCKET, $file_full_path))
                        {
                            $exist = TRUE;
                            $file_full_path = IMAGE_SERVER_PATH.PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.$file_name;
                            $file_location = $file_full_path;
                        }
                    } 
                    else 
                    {
                        $file_full_path = IMAGE_ROOT_PATH.$MediaSectionAlias.$SubDir.$file_name; 
                        $file_location = $file_full_path;
                        if(file_exists($file_full_path))
                        {                            
                            $exist = TRUE;    
                        }                        
                    }                            
                }
                //echo "<br> $i. ".$file_full_path." <br>";
                if($exist)
                {
                    $dir_name   = PATH_IMG_UPLOAD_FOLDER . $MediaSectionAlias;

                    $folder_arr = array($MediaSectionAlias."/56x56");

                    $this->check_folder_exist(PATH_IMG_UPLOAD_FOLDER, $folder_arr);

                    $name_parts = pathinfo($file_name);
                    $ext = strtolower($name_parts['extension']);

                    $file_name = str_replace($ext, "jpg", $file_name);
                    $file_location = str_replace($ext, "jpg", $file_location);

                    $file_full_path = PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.'220x220/'.$file_name;
                    $destinationFile = PATH_IMG_UPLOAD_FOLDER.$MediaSectionAlias.$SubDir.'56x56/'.$file_name;
                    if(strtolower(IMAGE_SERVER) == 'remote')
                    {
                        if($s3->getObjectInfo(BUCKET, $file_full_path))
                        {
                           $s3->copyObject(BUCKET, $file_full_path, BUCKET, $destinationFile, S3::ACL_PUBLIC_READ);
                        }
                        else
                        {
                            //echo "<br> File not exits ".$file_full_path." <br>";
                        }
                    }
                    else
                    {
                        if(file_exists($file_location))
                        {
                            copy(IMAGE_SERVER_PATH.$file_full_path,$destinationFile);
                        }
                        else
                        {
                            //echo "<br> File not exits ".$file_full_path." <br>";
                        }
                    }                     
                }               
            }
        }
    }

    /**
     * [delete_dangling_media Used to delete dangling media]
     */
    function delete_dangling_media() 
    {
        $previous_date = get_current_date('%Y-%m-%d 23:59:59', 1);

        $this->db->select('M.MediaID, MT.Name as MediaType');
        $this->db->select('M.ImageName', FALSE);
        $this->db->select('M.StatusID', FALSE);
        $this->db->select('M.MediaSectionID', FALSE);
        $this->db->select('MS.MediaSectionAlias', FALSE);

        $this->db->join(MEDIASECTIONS . " AS MS", ' MS.MediaSectionID = M.MediaSectionID', 'right');
        $this->db->join(MEDIAEXTENSIONS . ' ME', 'ME.MediaExtensionID=M.MediaExtensionID', 'LEFT');
        $this->db->join(MEDIATYPES . ' MT', 'MT.MediaTypeID=ME.MediaTypeID', 'LEFT');

        $this->db->from(MEDIA . " AS M");
        $this->db->where('M.StatusID', 1);
        $this->db->where('M.CreatedDate <= ', $previous_date);
        $this->db->limit(10);
        $query = $this->db->get();        

        //echo $this->db->last_query();die;
        if($query->num_rows()) 
        {
            $media_ids = array();
            foreach($query->result_array() as $row)
            {
                $file_name              = $row['ImageName'];
                $media_section_alias    = $row['MediaSectionAlias'];
                $media_type             = $row['MediaType'];
                $media_ids[]            = $row['MediaID'];           
                                       
                if(!empty($file_name) && !empty($media_section_alias)) 
                {            
                    
                    $thumb_arr  = $media_section_alias . '_thumb_size';
                    $dir_name   = PATH_IMG_UPLOAD_FOLDER . $media_section_alias;

                    //$file_path = $dir_name . '/' . $file_name;

                    if($media_type == 'Video') 
                    {
                        $ext = pathinfo($file_path, PATHINFO_EXTENSION);

                        $video_file = str_replace(".".$ext, ".mp4", $file_name);
                        $video_file_path = $dir_name . '/' . $video_file;
                        $this->delete_file($video_file_path);

                        $video_file = str_replace(".".$ext, ".ogg", $file_name);
                        $video_file_path = $dir_name . '/' . $video_file;
                        $this->delete_file($video_file_path);
                        
                        $video_file = str_replace(".".$ext, ".webm", $file_name);
                        $video_file_path = $dir_name . '/' . $video_file;
                        $this->delete_file($video_file_path);

                        $file_name = str_replace(".".$ext, ".jpg", $file_name);
                        $file_path = $dir_name . '/' . $file_name;
                    }
                    else
                    {
                        $file_path = $dir_name . '/' . $file_name;
                        $this->delete_file($file_path);

                        $file_path = $dir_name . '/org_' . $file_name;
                        $this->delete_file($file_path);    
                    } 
                    
                    foreach ($this->$thumb_arr as $i => $row) 
                    {
                        $w = $row[0];
                        $h = $row[1];                    
                        $file_path = $dir_name . '/' . $w . 'x' . $h . '/' . $file_name;
                        $this->delete_file($file_path);               
                    }                   
                }
            }
            if(count($media_ids) > 0)
            {
                $this->db->where_in('MediaID',$media_ids);
                $this->db->delete(MEDIA);              
            }            
        }
    }

    function delete_file($file_path)
    {
        if (strtolower(IMAGE_SERVER) == 'remote') 
        {
            $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);                        
            if($s3->getObjectInfo(BUCKET, $file_path))
            {
                // delete file
                $s3->deleteObject(BUCKET, $file_path);                
            }
        }
        else
        {
            $file_path = ROOT_PATH. '/' .$file_path;
            if(file_exists($file_path))
            {
                // delete file
                unlink($file_path);
            }
        }
    }
}
?>