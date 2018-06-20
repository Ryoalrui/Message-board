<?php
header('content-type:text/html;charset=UTF-8');
date_default_timezone_set('PRC');

// 连接数据库
$pdo=new pdo("mysql:host=localhost;dbname=msg",'root','1010LING');
$pdo->exec('set names utf8');

//读取数据
$res=$pdo->query('SELECT * FROM imooc_msg');
$datas=$res->fetchAll(PDO::FETCH_ASSOC);
// print_r($datas);

//采用预处理的方式写入数据库
$sql="INSERT imooc_msg(username,title,time,content) VALUES(:username,:title,:time,:content)";
$stmt=$pdo->prepare($sql);

//检测用户是否点击了提交按钮
if(isset($_POST['pubMsg']))//按钮点击了，代表有值了(isset)
{
  //绑定参数
  $username=$_POST['username'];
  $stmt->bindParam(":username",$username,PDO::PARAM_STR);

  //绑定参数
  $title=strip_tags($_POST['title']);
  $stmt->bindParam(":title",$title,PDO::PARAM_STR);

  //绑定参数
  $content=strip_tags($_POST['content']);
  $stmt->bindParam(":content",$content,PDO::PARAM_STR);

  //绑定参数
  $time=date('Y-m-d H:i:s');
  $stmt->bindParam(":time",$time,PDO::PARAM_STR);

  //输入数据
  $res=$stmt->execute();

  if($res!==false){
    echo "<script>alert('留言成功！');location.href='msg-mysql.php'</script>";//如果这里不跳转，会出现跳id和删不干净数据问题。原因是本地跳转界面和实际显示界面存在过度问题
  }else{
    echo "<script>alert('留言失败！');location.href='msg-mysql.php'</script>";//如若不进行跳转，过度会出现上述描述现象
  }
}
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
      <?php if(count($datas)>0):?>
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
        <?php foreach($datas as $val){ ?>
					<tr class="success">
						<td>
							<?php echo $val['id']; ?>
						</td>
						<td>
							<?php echo $val['username']; ?>
						</td>
						<td>
							<?php echo $val['title']; ?>
						</td>
						<td>
							<?php echo $val['content']; ?>
						</td>
            <td>
              <?php echo $val['time']; ?>
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
