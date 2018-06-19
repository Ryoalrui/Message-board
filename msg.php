<?php
header('content-type:text/html;charset=UTF-8');
date_default_timezone_set('PRC');
$filename='./msg.txt';
$msgs=[];
//检测文件是否存在
if(is_file($filename)){
  //文件存在，读取文件中的内容
  $string=file_get_contents($filename);
  if(strlen($string)>0){
    $msgs=unserialize($string);
  }
}
//检测用户是否点击了提交按钮
if(isset($_POST['pubMsg'])){//按钮点击了，代表有值了(isset)

  $username=$_POST['username'];
  $title=strip_tags($_POST['title']);
  $content=strip_tags($_POST['content']);
  $time=date('d/m/Y H:i:s');
  //将其快速组成关联数组
  $data=compact('username','title','content','time');
  array_push($msgs,$data);
  $msgs=serialize($msgs);
  if(file_put_contents($filename,$msgs)){//用了array_push，保留了上一次输入的内容
    echo "<script>alert('留言成功！');location.href='msg.php'</script>";
  }else{
    echo "<script>alert('留言失败！');location.href='msg.php'</script>";
  }
}
/*
$msgs=[
[...],
[...]
];
file_get-contents($filename)
file_put_contents($filename,$data)
serialize($data)
unserialize($data)
 */
// print_r($msgs);
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
<link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="page-header">
				<h1>
					IMOOC留言板<span>-v1.0</span>
				</h1>
			</div>
			<div class="hero-unit">
				<h1>
					Hello, world!
				</h1>
				<p>
					这是一个可视化布局模板, 你可以点击模板里的文字进行修改, 也可以通过点击弹出的编辑框进行富文本修改. 拖动区块能实现排序.
				</p>
				<p>
					<a rel="nofollow" class="btn btn-primary btn-large" href="#">参看更多 »</a>
				</p>
			</div>
      <?php if(is_array($msgs)&&count($msgs)>0):?>
			<table class="table nofollow">
				<thead>
					<tr>
						<th>
							ID
						</th>
						<th>
							用户
						</th>
            <th>
							标题
						</th>
						<th>
							时间
						</th>
						<th>
							内容
						</th>
					</tr>
				</thead>
				<tbody>
        <?php $id='1';foreach($msgs as $val){ ?>
					<tr class="success">
						<td>
							<?php echo $id++; ?>
						</td>
						<td>
							<?php echo $val['username']; ?>
						</td>
						<td>
							<?php echo $val['title']; ?>
						</td>
						<td>
							<?php echo $val['time']; ?>
						</td>
            <td>
              <?php echo $val['content']; ?>
						</td>
					</tr>
        <?php }; ?>
				</tbody>
			</table>
    <?php endif; ?>
			<form action='#' method='post'>
				<fieldset>
					 <legend>请留言</legend>
           <label>用户名</label><input type="text" name='username' required='required'/>
           <label>标题</label><input type="text" name='title' required='required'/>
           <label>内容</label><textarea name="content" rows="5" cols="30" required='required'></textarea>
           <br/>
           <input type="submit" class="btn btn-primary btn-lg" name="pubMsg" value="发布留言"/>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</body>
</html>
