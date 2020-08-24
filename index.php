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
            <div class="mdui-typo-display-1-opacity">目录</div>
            <div class="mdui-typo">
                <hr/>
            </div>
            <?php
                $path = "./";
                if (!is_dir($path)){
                    echo "ERROR";
                }
                else {
                    $arr = array();
                    $data = scandir($path);
                    foreach ($data as $value){
                        if($value != '.' && $value != '..'){
                            $arr[] = $value;
                        }
                    }
                    $arrlength=count($arr);
                    for($x = 0; $x < $arrlength; $x++) {
                        if ($arr[$x] != "index.php"){
                            echo "<button class=\"mdui-btn mdui-btn-block mdui-color-theme-accent mdui-ripple mdui-text-left\" onclick=\"window.open('https://www.inspire2030.cn/download/";
                            $type = pathinfo($arr[$x], PATHINFO_EXTENSION);
                            echo $arr[$x];
                            echo "')\">";
                            if (strcasecmp($type, "webp") == 0 || strcasecmp($type, "gif") == 0 || strcasecmp($type, "jpg") == 0 || strcasecmp($type, "svg") == 0 || strcasecmp($type, "png") == 0 || strcasecmp($type, "raw") == 0 || strcasecmp($type, "ico") == 0){
                                echo "<i class=\"mdui-icon material-icons\">image</i>";
                            }elseif (strcasecmp($type, "mp3") == 0 || strcasecmp($type, "wmv") == 0 || strcasecmp($type, "flac") == 0 || strcasecmp($type, "aac") == 0) {
                                echo "<i class=\"mdui-icon material-icons\">music_note</i>";
                            }elseif (strcasecmp($type, "mp4") == 0 || strcasecmp($type, "avi") == 0 || strcasecmp($type, "mov") == 0 || strcasecmp($type, "wmv") == 0 || strcasecmp($type, "flv") == 0 || strcasecmp($type, "mkv") == 0) {
                                echo "<i class=\"mdui-icon material-icons\">videocam</i>";
                            }else{
                                echo "<i class=\"mdui-icon material-icons\">insert_drive_file</i>";
                            }
                            echo $arr[$x];
                            echo "</button>";
                        }
                    }
                    if ($arrlength == 1){
                        echo "<button class=\"mdui-btn mdui-btn-block mdui-color-theme-accent mdui-ripple mdui-text-left\">空</button>";
                    }
                }
    
            ?>
        </div>
    </body>
</html>
