<!DOCTYPE html>
<html>
    <head>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/mdui@1.0.0/dist/css/mdui.min.css"
            integrity="sha384-2PJ2u4NYg6jCNNpv3i1hK9AoAqODy6CdiC+gYiL2DVx+ku5wzJMFNdE3RoWfBIRP"
            crossorigin="anonymous"
        />
        <script
            src="https://cdn.jsdelivr.net/npm/mdui@1.0.0/dist/js/mdui.min.js"
            integrity="sha384-aB8rnkAu/GBsQ1q6dwTySnlrrbhqDwrDnpVHR2Wgm8pWLbwUnzDcIROX3VvCbaK+"
            crossorigin="anonymous"
        ></script>
        <style>
            .empty{
                width: 100%;
                height: 20px;
            }
        </style>
        <title>下载</title>
    </head>
    <body class="mdui-theme-primary-blue mdui-theme-accent.orange mdui-theme-layout-auto mdui-appbar-with-toolbar">
        <div class="mdui-appbar mdui-appbar-fixed mdui-appbar-scroll-hide">
            <div class="mdui-toolbar mdui-color-theme">
                <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">file_download</i></a>
                <span class="mdui-typo-title">下载</span>
                <div class="mdui-toolbar-spacer"></div>
                <a href="javascript: location.reload();" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
                <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>
            </div>
        </div>
        <div class="empty"></div>
        <div class="mdui-container">
            <div class="mdui-typo-display-1-opacity">
                <?php
                    if($_GET["folder"] != ""){
                        echo $_GET["folder"];
                    }else echo "目录";
                ?>
            </div>
            <div class="mdui-typo">
                <hr/>
            </div>
            <?php
                function returnFileType($suffix){
                    if (strcasecmp($suffix, "webp") == 0 || strcasecmp($suffix, "gif") == 0 || strcasecmp($suffix, "jpg") == 0 || strcasecmp($suffix, "svg") == 0 || strcasecmp($suffix, "png") == 0 || strcasecmp($suffix, "raw") == 0 || strcasecmp($suffix, "ico") == 0){
                        return "image";
                    }elseif (strcasecmp($suffix, "mp3") == 0 || strcasecmp($suffix, "wmv") == 0 || strcasecmp($suffix, "flac") == 0 || strcasecmp($suffix, "aac") == 0){
                        return "music_note";
                    }elseif (strcasecmp($suffix, "mp4") == 0 || strcasecmp($suffix, "avi") == 0 || strcasecmp($suffix, "mov") == 0 || strcasecmp($suffix, "wmv") == 0 || strcasecmp($suffix, "flv") == 0 || strcasecmp($suffix, "mkv") == 0){
                        return "videocam";
                    }elseif (strcasecmp($suffix, "zip") == 0 || strcasecmp($suffix, "7z") == 0 || strcasecmp($suffix, "rar") == 0 || strcasecmp($suffix, "tar") == 0){
                        return "archive";
                    }elseif (strcasecmp($suffix, "pdf") == 0){
                        return "picture_as_pdf";
                    }else{
                        return "insert_drive_file";
                    }
                }
                function outputFile($dirPath){
                    $url = substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], 0, -10);
                    $url .= substr($dirPath, 2)."/";
                    if(!is_dir($dirPath)){
                        return;
                    }else{
                        $status = 0;
                        $psw = "";
                        $fileList = array();
                        $fileData = scandir($dirPath);
                        foreach($fileData as $value){
                            if($value != '.' && $value != '..'){
                                if($value == ".hidden"){
                                    $status = 2;
                                    break;
                                }
                                if(substr($value, 0, 9) == ".password"){
                                    $psw = substr($value, 10);
                                    $status = 1;
                                }
                                if($value != "index.php" && substr($value, 0, 9) != ".password"){
                                    $flieList[] = $value;
                                }
                            }
                        }
                        if($status == 1 && $_POST["password"] != $psw){
                            echo "<form action=\"index.php?folder=".$dirPath."\" method=\"post\">";
                            echo "<div class=\"mdui-textfield mdui-textfield-floating-label\" style=\"padding:0\">";
                            if($_POST["password"] != ""){
                                echo "<i class=\"mdui-icon material-icons\" style=\"margin:0;padding:0;color:red;\">lock</i>";
                            }
                            else{
                                echo "<i class=\"mdui-icon material-icons\" style=\"margin:0;padding:0\">lock</i>";
                            }
                            echo "<label class=\"mdui-textfield-label\">密码</label>";
                            echo "<input class=\"mdui-textfield-input\" type=\"password\" name=\"password\"/>";
                            echo "</div>";
                            echo "</from>";
                            return;
                        }
                        if($status == 2){
                            echo "&emsp;&ensp;空文件夹";
                            return;
                        }
                        if(empty($flieList) == true){
                            echo "&emsp;&ensp;空文件夹";
                            return;
                        }
                        foreach($flieList as $value){
                            if(!is_dir($dirPath.'/'.$value)){
                                echo "<button class=\"mdui-btn mdui-btn-block mdui-color-theme-accent mdui-ripple mdui-text-left\" onclick=\"window.open('http://".$url.$value."')\">";
                                echo "&ensp;<i class=\"mdui-icon material-icons\">".returnFileType(pathinfo($value, PATHINFO_EXTENSION))."</i>&ensp;";
                                echo $value;
                                echo "</button>";
                            }else{
                                echo "<div class=\"mdui-panel mdui-panel-gapless mdui-shadow-0\" mdui-panel>"."<div class=\"mdui-panel-item mdui-shadow-0\">";
                                echo "<div class=\"mdui-panel-item-header\"><i class=\"mdui-icon material-icons\">folder</i>&ensp;".$value."</div>";
                                echo "<div class=\"mdui-panel-item-body\">";
                                outputFile($dirPath.$value);
                                echo "</div></div></div>";
                            }
                        }
                    }
                }
                $target = $_GET["folder"];
                if($target == ""){
                    $target = "./";
                }
                outputFile($target);
            ?>
        </div>
    </body>
</html>
