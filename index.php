<?php
require_once 'dir.func.php';
require_once 'file.func.php';

$path = "file";
$info = readDirectory($path);
// print_r($info);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>文件管理</title>
	<link rel="stylesheet" href="cikonss.css" />
	<script src="jquery-ui/js/jquery-1.10.2.js"></script>
	<script src="jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
	<link rel="stylesheet" href="jquery-ui/css/cikonss.css
jquery-uiui-lightness/jquery-ui-1.10.4.custom.css"  type="text/css"/>
	<style type="text/css">
		body,p,div,ul,ol,table,dl,dd,dt{
			margin:0;
			padding: 0;
		}
		a{
			text-decoration: none;
		}
		ul,li{
			list-style: none;
			float: left;
		}
		#top{
			width:100%;
			height:48px;
			margin:0 auto;
			background: #E2E2E2;
		}
		#navi a{
			display: block;
			width:48px;
			height: 48px;
		}
		#main{
			margin:0 auto;
			border:2px solid #ABCDEF;
		}
		.small{
			width:25px;
			height:25px;
			border:0;
	}
	</style>
</head>
<body>
	<h1>51growup-在线文件管理器</h1>
	<div id="top">
		<ul id="navi">
			<li><a href="index.php" title="主目录"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-home"></span></span></a></li>
			<li><a href="#"  onclick="show('createFile')" title="新建文件" ><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-file"></span></span></a></li>
			<li><a href="#"  onclick="show('createFolder')" title="新建文件夹"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-folder"></span></span></a></li>
			<li><a href="#" onclick="show('uploadFile')"title="上传文件"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-upload"></span></span></a></li>
			<?php 
			$back=($path=="file")?"file":dirname($path);
			?>
			<li><a href="#" title="返回上级目录" onclick="goBack('<?php echo $back;?>')"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-arrowLeft"></span></span></a></li>
		</ul>
	</div>
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bgcolor="#ABCDEF" align="center">
		<tr>
			<td>编号</td>
			<td>名称</td>
			<td>类型</td>
			<td>大小</td>
			<td>可读</td>
			<td>可写</td>
			<td>可执行</td>
			<td>创建时间</td>
			<td>修改时间</td>
			<td>访问时间</td>
			<td>操作</td>
		</tr>
		<?php
		if ($info['file']) {
			foreach ($info['file'] as $key => $val) {
			$p = $path . "/" . $val;
		?>
		<tr>
			<td><?php echo $key + 1 ?></td>
			<td><?php echo $val ?></td>
			<td><?php $src = filetype($p) == "file"?"file_ico.png":"folder_ico.png";?><img src="images/<?php echo $src;?>" alt="" title="文件"></td>
			<td><?php echo transByte(filesize($p));?></td>
			<td>
				<?php $src = is_readable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt="" title="">
			</td>
			<td>
				<?php $src = is_writable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt="" title="">
			</td>
			<td>
				<?php $src = is_executable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt="" title="">
			</td>
			<td><?php echo date("Y-m-d H:i:s",filectime($p))?></td>
			<td><?php echo date("Y-m-d H:i:s",filemtime($p))?></td>
			<td><?php echo date("Y-m-d H:i:s",fileatime($p))?></td>
			<td>
			<?php
			//得到文件扩展名
				$ext=strtolower(end(explode(".",$val)));
				$imageExt=array("gif","jpg","jpeg","png");
				if(in_array($ext,$imageExt)){
					?>
					<a href="#"  onclick="showDetail('<?php echo $val;?>','<?php echo $p;?>')"><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
			<?php
				}else{
			?>
			<a href="index.php?act=showContent&path=<?php echo $path;?>&filename=<?php echo $p;?>" ><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
			<?php }?>
			<a href="index.php?act=editContent&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/edit.png"  alt="" title="修改"/></a>|
			<a href="index.php?act=renameFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/rename.png"  alt="" title="重命名"/></a>|
			<a href="index.php?act=copyFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/copy.png"  alt="" title="复制"/></a>|
			<a href="index.php?act=cutFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/cut.png"  alt="" title="剪切"/></a>|
			<a href="#"  onclick="delFile('<?php echo $p;?>','<?php echo $path;?>')"><img class="small" src="images/delete.png"  alt="" title="删除"/></a>|
			<a href="index.php?act=downFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small"  src="images/download.png"  alt="" title="下载"/></a>
			</td>
		</tr>

		<?php
			}
		}
		?>
	</table>
</body>
</html>