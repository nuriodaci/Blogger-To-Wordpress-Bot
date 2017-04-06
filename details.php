<?php
$url =$_POST['url'];
$page=$_POST['page'];

$response=get_json($url,$page);
$myresponse=json_encode($response,true);


function get_json($url,$page){
$startindex=1;
if ($page>1) {
  $startindex=$page*20;
}

if (mb_substr($url)=='/') {
  $url=$url.'atom.xml?redirect=false&start-index='.$startindex.'&max-results=20&alt=json';
}
else{
  $url=$url.'/atom.xml?redirect=false&start-index='.$startindex.'&max-results=20&alt=json';
}


$ch = curl_init( $url );
curl_setopt($curl, CURLOPT_REFERER, "https://google.com");
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$res = curl_exec($ch);
curl_close($ch);
$res=json_decode($res,true);

return $res['feed']['entry'];

}

?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="http://v4.pingendo.com/assets/bootstrap/themes/default.css" rel="stylesheet" type="text/css">
  <style>
    body {
      background-color: #eee;
    }
    .list-group {
    max-height:600px;
    overflow-y:auto;    
    }
  </style>
</head>

<body>
   <?php
              for ($i=0; $i <count($response) ; $i++) { 
              preg_match_all('@<img (.*?) src="(.*?)"@si',$response[$i]['content']['$t'],$resimlink);
              $resim[$i]=$resimlink[2][0];
              $resimler=json_encode($resim,true);
              }
              ?>

              <?php

              for ($j=0; $j <count($response) ; $j++) { 
                for ($i=0; $i <count($response[$j]['category']) ; $i++) {
                if (count($response[$j]['category'])<1) {
                  $cats[$j]='none';
                }
                if (count($response[$j]['category'])-$i==1) {
                  $cats[$j].=$response[$j]['category'][$i]['term'];
                }
                else{
                  $cats[$j].=$response[$j]['category'][$i]['term'].',';
                }
              }

                


               $cates=json_encode($cats,true);
              }
              ?>
  <?php
  echo '<script type="text/javascript">';
  print_r('var mydata ='.$myresponse.';');
  echo 'console.log(mydata);';
  print_r('var images ='.$resimler.';');
  echo 'console.log(images);';
  print_r('var tags ='.$cates.';');
  echo 'console.log(tags);';
  echo '</script>';
  ?>
  <div class="bg-inverse section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-xs-center" >Blogger To Wordpress Bot</h1>
          <hr>
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <hr>
    <div class="container">
      <div class="row" >
      <form action="details.php" method="POST">
        <div class="col-xs-9">
          <input type="text" id="url" name="url" class="form-control" placeholder="Blogger Url" value="<?php echo $url;?>">
        </div>
        <div class="col-xs-3">
          <button type="submit" class="btn btn-block btn-primary">Get Contents</button>
        </div>
        </form>
      </div>
    </div>
    <hr>
  </div>
  <div class="section">
    <div class="container">
      <div class="row" >
        <div class="col-lg-5">
          <div class="list-group">
<?php
for ($i=0; $i <count($response) ; $i++) {
  if ($i==0) {
   echo '<a  id="list'.$i.'" onclick="get('.$i.')" class="list-group-item active">'.$response[$i]['title']['$t'].'</a>';
  }else{
    echo '<a  id="list'.$i.'" onclick="get('.$i.')" class="list-group-item">'.$response[$i]['title']['$t'].'</a>';
  }
  
}
?>

           

          </div>
          <div class="row text-xs-center">
            <hr>
            <div class="col-xs-5">
              <a onclick="prev()" class="btn btn-danger">&lt;- Prev. Page</a>
            </div>
            <div class="col-xs-2">
              <p id="curpage"> <?php echo $page; ?></p>
            </div>
            <div class="col-xs-5">
              <a onclick="next()" class="btn btn-danger">Next Page -&gt;</a>
            </div>

          </div>
        </div>
        <div class="col-lg-7">
          <form class="text-xs-left" >
            <div class="form-group">
              <label>Title</label>
              <input type="text" id="title" class="form-control" value="<?php echo $response[0]['title']['$t'];?>">
            </div>
            <div class="form-group">
              <label>Picture</label>
              <img id="img" class="center-block img-fluid img-rounded" src="<?php echo $resim[0];?>" >
              <input id="imgurl" type="text" class="form-control" value="<?php echo $resim[0];?>">
            </div>
            <div class="form-group">
              <label>Tags</label>
              
              <input id="tags" type="text" class="form-control" value="<?php echo $cats[0];?>">
            </div>
            <div class="form-group">
              <label>Content</label>
              <textarea id="content" class="form-control" rows="10"><?php echo $response[0]['content']['$t'];?></textarea>
            </div>
            <div class="form-group text-xs-center">
              <a id="add" onclick="add(0)" type="submit" class="btn btn-danger">Add My Site</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  

  function get(index){
  $( ".list-group-item" ).removeClass( "active" );
  $( "#list"+index ).addClass( "active" );
  $("#add").attr("onclick","add("+index+")");
  $( "#title" ).val(mydata[index].title.$t);
  $('#img').attr('src', images[index]);
  $('#imgurl').val(images[index]);
  $('#tags').val(tags[index]);
  $('#content').html(mydata[index].content.$t);

  
  }
  function add(index){
    $.post( "insert.php", { name: $( "#title" ).val(), content:$( "#content" ).val(),tag:$( "#tags" ).val(),img:$( "#imgurl" ).val()})
  .done(function( data ) {
    alert( "Inserted ..." + data );
  });
  }

  function prev(){
    var ppp=$( "#curpage" ).text();
    var curpage=parseInt(ppp);
    if (curpage>1) {

      var redirect = 'details.php';
redirectPost(redirect, {url:$( "#url" ).val(), page: curpage-1});

  }}
  function next(){
    var ppp=$( "#curpage" ).text();
    var curpage=parseInt(ppp);
       var redirect = 'details.php';
redirectPost(redirect, {url:$( "#url" ).val(), page: curpage+1});

 

  
  }

     function redirectPost(location, args)
    {
        var form = '';
        $.each( args, function( key, value ) {
            form += '<input type="hidden" name="'+key+'" value="'+value+'">';
        });
        $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
    }

</script>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
</body>

</html>