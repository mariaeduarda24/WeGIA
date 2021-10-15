<?php 

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();

    if(!isset($_SESSION['atendido'])){
        header ("Location: profile_paciente.php?idatendido=$id");
    }
   	/*if(!isset($_SESSION['usuario'])){
   		header ("Location: ../index.php");
   	}*/
      
      $config_path = "config.php";
      if(file_exists($config_path)){
         require_once($config_path);
      }else{
         while(true){
            $config_path = "../" . $config_path;
            if(file_exists($config_path)) break;
         }
         require_once($config_path);
      }

      $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $id_pessoa = $_SESSION['id_pessoa'];
      $resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
      if(!is_null($resultado)){
         $id_cargo = mysqli_fetch_array($resultado);
         if(!is_null($id_cargo)){
            $id_cargo = $id_cargo['id_cargo'];
         }
         $resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=12");
         if(!is_bool($resultado) and mysqli_num_rows($resultado)){
            $permissao = mysqli_fetch_array($resultado);
            if($permissao['id_acao'] < 7){
           $msg = "Você não tem as permissões necessárias para essa página.";
           header("Location: ../../home.php?msg_c=$msg");
            }
            $permissao = $permissao['id_acao'];
         }else{
              $permissao = 1;
             $msg = "Você não tem as permissões necessárias para essa página.";
             header("Location: ../../home.php?msg_c=$msg");
         }	
      }else{
         $permissao = 1;
       $msg = "Você não tem as permissões necessárias para essa página.";
       header("Location: ./home.php?msg_c=$msg");
      }	
  

  include_once '../../classes/Cache.php';    
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
  require_once "../personalizacao_display.php";
  
  require_once ROOT."/controle/FuncionarioControle.php";
  $cpf1 = new FuncionarioControle;
  $cpf1->listarCpf();

  require_once ROOT."/controle/AtendidoControle.php";
  $cpf = new AtendidoControle;
  $cpf->listarCpf();

  require_once ROOT."/controle/EnderecoControle.php";
  $endereco = new EnderecoControle;
  $endereco->listarInstituicao();
   
   
   $id=$_GET['idatendido'];
   $cache = new Cache();
   $teste = $cache->read($id);
   //$atendidos = $_SESSION['idatendido'];
   // $atendido = new AtendidoDAO();
   // $atendido->listar($id);
   // var_dump($atendido);
   
   if (!isset($teste)) {
   		
   		header('Location: ../../controle/control.php?metodo=listarUm&nomeClasse=AtendidoControle&nextPage=../html/saude/profile_paciente.php?idatendido='.$id.'&id='.$id);
      }
   
?>

    <!-- Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
    <!-- Specific Page Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        
    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
    <!-- Theme Custom -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
    <!-- Theme Initialization Files -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>

    <!-- javascript functions -->
    <script src="<?php echo WWW;?>Functions/onlyNumbers.js"></script>
    <script src="<?php echo WWW;?>Functions/onlyChars.js"></script>
    <script src="<?php echo WWW;?>Functions/mascara.js"></script>

    <!-- jkeditor -->
    <script src="<?php echo WWW;?>assets/vendor/ckeditor/ckeditor.js"></script>
        
    <!-- jquery functions -->

    <script>
        $(function(){
            var funcionario=[];
            $.each(funcionario,function(i,item){
                $("#destinatario")
                    .append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+" "+item.sobrenome+"</option>"));
            });
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");

            //var id_memorando = 1;
            //$("#id_memorando").val(id_memorando);

            CKEDITOR.replace('despacho');
        });
    </script>
    

    <style type="text/css">
        .select{
            position: absolute;
            width: 235px;
        }
        .select-table-filter{
            width: 140px;
            float: left;
        }
        .panel-body{
            margin-bottom: 15px;
        }
        img{
        	margin-left:10px;
        }
        #div_texto
        {
            width: 100%;
        }
        #cke_despacho
        {
            height: 500px;
        }
        .cke_inner
        {
            height: 500px;
        }
        #cke_1_contents
        {
            height: 455px !important;
        }
        .col-md-3 {
            width: 10%;
        }
    </style>
<script>
        $(function(){
            var funcionario=[];
            $.each(funcionario,function(i,item){
                $("#destinatario")
                    .append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+" "+item.sobrenome+"</option>"));
            });
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");

            //var id_memorando = 1;
            //$("#id_memorando").val(id_memorando);

            CKEDITOR.replace('despacho');
        });
</script>



<!doctype html>
<html class="fixed">
   <head>
      <!-- Basic -->
      <meta charset="UTF-8">
      <title>Informações paciente</title>
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <!-- Web Fonts  -->
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
      <!-- Vendor CSS -->
      <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.css" />
      <link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.css" />
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
      <link rel="stylesheet" href="../../assets/vendor/magnific-popup/magnific-popup.css" />
      <link rel="stylesheet" href="../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
      
      <!-- LINK GRANDAO-->
      <link rel="icon" href="data:image;base64,iVBORw0KGgoAAAANSUhEUgAACPkAAAahCAYAAADcgc11AAAACXBIWXMAAA7EAAAOxAGVKw4bAAALUmlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDIgNzkuMTYwOTI0LCAyMDE3LzA3LzEzLTAxOjA2OjM5ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIiB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOC0wMy0xM1QxNzo0MjoxMy0wMzowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxOC0wOC0xNlQxNjowMDoxNi0wMzowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTgtMDgtMTZUMTY6MDA6MTYtMDM6MDAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6N2M1N2JjNDAtZGQzNS02ODQ5LTg2MzctYTUxZDQ3MmE0YjIxIiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MTkxMTlhMTMtNWQ3Ni0xYTQ3LWI1ODgtOWVhNjQwZDliZTg2IiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6ZWIwNmE3NTItMGI2Yi1hNzQ1LTk0OTMtZGM1Zjc2ZTY5NmE4IiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgcGhvdG9zaG9wOklDQ1Byb2ZpbGU9IkFkb2JlIFJHQiAoMTk5OCkiIHRpZmY6T3JpZW50YXRpb249IjEiIHRpZmY6WFJlc29sdXRpb249IjQ1MDAwMDAvMTAwMDAiIHRpZmY6WVJlc29sdXRpb249IjQ1MDAwMDAvMTAwMDAiIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiIGV4aWY6Q29sb3JTcGFjZT0iNjU1MzUiIGV4aWY6UGl4ZWxYRGltZW5zaW9uPSI0NTAwIiBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzYwMCI+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNyZWF0ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6ZWIwNmE3NTItMGI2Yi1hNzQ1LTk0OTMtZGM1Zjc2ZTY5NmE4IiBzdEV2dDp3aGVuPSIyMDE4LTAzLTEzVDE3OjQyOjEzLTAzOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpkMmFhZDg3Ni03ZDRhLTk3NDUtOTk4NC0wOTU2OTlhNzNmNzkiIHN0RXZ0OndoZW49IjIwMTgtMDMtMTNUMTc6NDI6MjgtMDM6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjkzNzhmMTBjLWI5MDUtNDA0OS1hNzgyLTU4MjUwMTg4NTk0YyIgc3RFdnQ6d2hlbj0iMjAxOC0wMy0yMFQxNjoyNzo0NC0wMzowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6ZDc4ODA5MjYtZjZiZS1jOTQ3LTgxOWUtYWU5Mjk0ZmQwYjQ3IiBzdEV2dDp3aGVuPSIyMDE4LTAzLTIwVDE2OjI3OjQ0LTAzOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo3YzU3YmM0MC1kZDM1LTY4NDktODYzNy1hNTFkNDcyYTRiMjEiIHN0RXZ0OndoZW49IjIwMTgtMDgtMTZUMTY6MDA6MTYtMDM6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjkzNzhmMTBjLWI5MDUtNDA0OS1hNzgyLTU4MjUwMTg4NTk0YyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDplYjA2YTc1Mi0wYjZiLWE3NDUtOTQ5My1kYzVmNzZlNjk2YTgiIHN0UmVmOm9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDplYjA2YTc1Mi0wYjZiLWE3NDUtOTQ5My1kYzVmNzZlNjk2YTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5xL5NgAAHIcklEQVR4nOzdf3zXdb3//8c2BuOnwBgwhhhmnuz4I/sFGp23WcsOHRJTO4pl9PNrP86ijx7So0GWWpoWkKX9MvMHEoqsQ9FJygMnkvkTVp5+mB2T32xs48f4OX58/xiamj8YbO/n+7339Xq57AKMAbdjR9zGnceraP/+/QEAAAAAAAAAAOSu4tQBAAAAAAAAAADAyzPyAQAAAAAAAACAHGfkAwAAAAAAAAAAOc7IBwAAAAAAAAAAcpyRDwAAAAAAAAAA5DgjHwAAAAAAAAAAyHFGPgAAAAAAAAAAkOOMfAAAAAAAAAAAIMcZ+QAAAAAAAAAAQI4z8gEAAAAAAAAAgBxn5AMAAAAAAAAAADnOyAcAAAAAAAAAAHKckQ8AAAAAAAAAAOQ4Ix8AAAAAAAAAAMhxRj4AAAAAAAAAAJDjjHwAAAAAAAAAACDHGfkAAAAAAAAAAECOM/IBAAAAAAAAAIAcZ+QDAAAAAAAAAAA5zsgHAAAAAAAAAABynJEPAAAAAAAAAADkOCMfAAAAAAAAAADIcUY+AAAAAAAAAACQ44x8AAAAAAAAAAAgxxn5AAAAAAAAAABAjjPyAQAAAAAAAACAHGfkAwAAAAAAAAAAOc7IBwAAAAAAAAAAcpyRDwAAAAAAAAAA5DgjHwAAAAAAAAAAyHFGPgAAAAAAAAAAkOOMfAAAAAAAAAAAIMcZ+QAAAAAAAAAAQI4z8gEAAAAAAAAAgBxn5AMAAAAAAAAAADnOyAcAAAAAAAAAAHKckQ8AAAAAAAAAAOQ4Ix8AAAAAAAAAAMhxRj4AAAAAAAAAAJDjjHwAAAAAAAAAACDHGfkAAAAAAAAAAECOM/IBAAAAAAAAAIAcZ+QDAAAAAAAAAAA5zsgHAAAAAAAAAABynJEPAAAAAAAAAADkOCMfAAAAAAAAAADIcUY+AAAAAAAAAACQ44x8AAAAAAAAAAAgxxn5AAAAAAAAAABAjjPyAQAAAAAAAACAHGfkAwAAAAAAAAAAOc7IBwAAAAAAAAAAcpyRDwAAAAAAAAAA5DgjHwAAAAAAAAAAyHFGPgAAAAAAAAAAkOOMfAAAAAAAAAAAIMcZ+QAAAAAAAAAAQI7rkTqAwvSH9TtSJ3Savfv2x7797V/u3b8/iouKokdxUZQUR5QUF8UDf9kaRUURxUVFUVwc0aO4KHr1KI6y0uLo27M4+vUqiRWrt0VRUfv3lZYURe/S4uhfVhKD+vSIFau2RUlxUfTuWRxHlJVEeb8e8dvV26NHSVH061USQ/r1iD837IyS4qLo27M4hvYvjScbd0ZpSVEMKCuJEUf0jMfXbo++vUqickBp/LlxZ5T1KI4h/XrEqMG94qG/tsagPj1i9JBe8djKbVHRvzRu+p/18f43lseIAT3jr827ok/P4jhyUK94YsOO6F9WEq8ZWhb1q7fHiCNKY2XL7ujXqySOHVoWv12zPUYO6hl/bdoVg/r0iOOG947HVm2L1w7rHY+v3R6jBveKpzbujOEDSmPdlrYY3LdH3PJAQ3zgLRVxwog+Ub9mW/xjZZ/43Zrt8brK9h/zjyP6xP+u2x7HV/aJx9dtjxNG9In/XbsjThrZJx5fuz3ufHhjXDimIm57sDE+/tZh0djaFqMG94pVzbvi2GG948nGnfH6kX3ij+t3xJ0Pb3z2bV4ztCz+b+OueOOovvHH9Tvitgcb47Nvr4xVLbvijaP6xR837IjbH2yMi985Ip5u2hX3LG+KT4wbFg1b2+L1I/vGk407446HGuM/3l0VT23cFXc9sjE+/66qeLppV8x5dGP8+ztHxNPNu2LuY03x/94xIla17Iq7H2uKz7+rKlY2t7/9tPEjY1XL7mjZvidOPbp/rGrZFes2t8U9y5viC/88MtZu3h3N2/bE/PrmuOyMqli7eXds3rE3auub49+rR8S6zW3Ruqv921OrR0TD1rbYvGNvzK9vji++58jYsLUtmlrbYu5jTRERccW7R8bGbW3RvG1P7N67P2rrm+Pq946KTdv3RMv2PbFpx964Z3n72355wpHtr9u+N7bs3Bt79rW/fUTEF99zZGzbtTdad++Lbbv2xrbd+2Lvc74/IuKqCUfGzrb9sWPPvtjZti927dkXu/bsj9179sXuPftjf8Tz3r6zTDxpcERE9OxRFL1K2v89KystirLS4uhdWhx9ehbHpbUrn337s08uj369iqN/r5LoX1YSA3v3iM/XPh0TTxocpSVFMbB3jyjv2yPK+/WIf7/36Tjr9YOjvE+PqOhfGl/5xZqYeNLg6NOzOIYP6BnDB5TGA/+3Nfr3KomqgT3jq/etife9fnBUHtEzjhrcK5b939ao6F8aRw/pFQ8+1RrDB5TGTb/eEOe+oTxeVd4rvrZobUweWxGvq+wTDz/dGsdUlMUfN+yIVw3uFU817YrKI3rGus27n/1y5MCesWbT7njN0LJ4qmlXnFjVJ/7csDO27NwbrxrcK9Zu2R1zH22KT2eGR2NrW+zesz+OHlIWG1vbYtvufTHmVf1iY2tbbNqxN1p37Y22vftjz779cerR/WNnW/v/Trv37o+IiOKi9pdnfu8CCkvbgd8Lnquo6G9f37VnX0RE9Cxp//1hw9a22L1nX+zbH7Fv//7Yvz9i/4Gv7zvw9ROq+kTE81/3zNef+TH79kXsi/2xb1/E/ojYt29/7IuI/fv3x959B77cHwd+/PN/nme/jPbvP2FE+6/3/I5nfr0X+bVf+Hb7IvYdaHhuy759z/m1428//oSqPrH/7/+x8QKtB96P2L57X7Ttbf9vT/v71H/7Z/3MP8d9+/dHUVFRFEX7//8VRUQURZQUFUVJcVH0KI4oLWn/736fniXRr1dxPLbyb+9j9+pRHH16FceAXiVxRO+SeHTltvb3u3sWxxG9e8SQvj1i+aptUdqj/X3oin6l8Yf1O6L0wPvcwwe0f7usR3EM7NP+3/rHVm2LAWXtX//Duh3Rp2dxVB7RM55s3Bl9ehZH1cCe8eeGndG3V3GMGtQr/rh+Rwzq0yOOHtIrVqzeHsMGlMaaTbujb8/ieHVFWTy+dntUHtH+3/d+vUriH4aVxe/WbI9XH3ifoOqInrF60+4Y2LskXlfZJx5buS1eO7z9febXDG1/m9HlveKpjbviyEE9Y2XL395vGD6gNNZvaXv221UH3o84clDPWN2yO0YN7hUrm3fFqyvK4i8bd8brhveOP23YGSdW9Ynfr98Rcx7ZGJPHVsStdY3x6czwWLtpd/xjZZ94onFHzH20KT5yytBo3r4njh7SK/7atCtOGtk3/tzQ/v7y506vjJUtu+PNR/WNJzbsjObte+K44b3jL407Y+5jTVHz9spY3bIr7l3RHJ9827BYv6Ut3vyqfvF/jTtj47Y9cfKRfeOvTbuiZfueeNOo9q9v3LYnThndP1a27Ip1m3fHvSua45J3jog1m3bHXY9sjKsmHBmrN+2ODVvbYv6K9velV7fsjq27/va+9PrNbc9++/Pvqor1W/72vvYX/nlkNLS2RVPrnrhneVN87X1HxcbWPdHU2hbN2/fEvSva34+94t0jo3n7nmjetid27tkXtfXNcd1ZR8WmHXtiy47296Nbd+199u0jIqaNH9n++p17Y3vbvtixe1/Mf8H7xV/6lyNjx4Hv27V3/4H3pfdF23PeP+vM96UnnjQ4iqL9feiePYqjV4/2f2d6l/7t49bLfvK396HPOmlw9D7wsWz7+9Al8YUFq579vn5lJTG4T48Y3LdHTP/pqph40uAo61Ec5f16REW/0vjiz1a1v1/dt0eMOKJnfGnh6njf6wfH0P6lMeKInjHtp6vi3DeUx8iBPeMb96+Ls14/OCoH9Ixv/8/6eN/rB0fVwJ7xzcXr49w3lMfRQ8riTxt2xBG9S+J1w/vEIysPvB+9fkdUDWz/d6aiX2l87zcb4iOnDI1bljXER08dGk3b9kTlgX8vRg8pi1Utu+L1I/vGnxt2xOYde+PYYb1jdcuu2LZ7Xxw7tCzWbWn/2OsNR/aNhq1t0bJ9b+xo2xf79u2PE6r6xJYde2PHnn2xq21ftO3723+7IiJKiuLA71NF0a+sJPr2LI4jepd02v9+0JVeteGJ2LN+fbStXx99x46NvS0t0dbYGG3r1kXfMWNiT1NT7GlsjLbVq6P/aafFno0bo239+ujzpje1v+2GDdG2bl30e9vbYk9TU/uPe+b7Dvw8/d761tjb0hK716z5u5+n79ixz379uT/PM79mv7e+9e9+nmd/zVNOed7P88yvufvpp//u53nm19z19NN///O87W2x58DXX/jPoN9b3xptGza84j+DvZs3R3Hv3lFaVRUREXsaGyMiomTAgOf98+5RUZH1/42BtPZu3hz7d+2K6NEjinv2jOL+/WPdVVdFca9e0WP48Oj1qldFn9e/PjZ8/etROmpU9H/b26L5jjui51FHxRHveU80fve7MaC6Orb8/OfR+/Wvj8abb47yD384mn74w6i46KJovPnmGHHllbHl5z+PipqaaLnrrti0YEEMv/TSaF28OIZ9/vOx+Wc/i52PPx7DLrkkti5ZEtsffjhGXHVVbF++PLYuWhSb77svjlmwIHbU10frAw/E5oULIyJi9G23xY7f/z621dXF1sWLIyLi1ffcE7vXrIldTz4ZO373u2dff+yiRbF306Znf2/dvXZttK1cGfu2bYvWurrn/TP5h8WLS/bt3Nl3/44dffdu394/9uzpuX/PntJ9O3Y8+5vmvq1bB73wQ+6iHj12F/fuve2Zbxf37r2lqEePtqJevXYWl5VtKyor21bcq9e2P7397Xtf+L9Dv7Fjo3T48CitqooeQ4ZEyeDB0WPQoCg54ogoOeKI+NNpp/3t7Soro+fo0VE6cmSUDhsWpUOGxBNnnBEREf0zmej1mtdE2T/8Q/QcOTJKhw6NP73jHc/+/L1POCF6HXNM9Bw58tnXlx1/fPQ+4YQoe/Wr48//8i/trzvuuOjzxjdGr9Gj48/veU/0O+WU6POGN0SfN74x/vqRj0RExKCzzoq+p54avY87Lv78L/8S/U87Lfr/0z9Fnze8IZ6cODEGvOMd0e+f/in6nHxyPPne98aA6uoY8I53RJ+TT46106dHr9e8Jga84x3x1OTJ0W/cuOifyUTft7wlnjzzzBg8aVIc8a53xVOTJ8cR73pX9H/3u6PvySfHmv/4j+iXyUT/f/qnWPelL0XfsWOj/+mnx/prrok+b3xjDHjnO2P9tddG75NOiiPGj4/1X/lK9D311BjwrnfFuiuvjAHV1dH/tNNi7ZVXxhETJsTqSy6JQWedFQPPOScav/nN6PPGN8YR73lPrLvmmhj4L/8Sqy+9NAadc04MOuecaJgxIwZUV8faL385Bk2cGIP+9V+jYdasOOI974k1V1wR5R/8YAz+13+N9ddfH4P/9V+j6Uc/ir6nnhobvv71GPyv/xqDP/CBaJgxI8ovvDAab745Bp55Zqy+9NIYNmVKbJgxI8o//OEonzSp/d+hD30oGm+6qf3Lm2+O8g9+MJpuuy0GX3BBNN12W5RfcEE03XlnDD7//Gi+664YfN550TxnTpRfcEE0z5kTQz784Wi67bYY8vGPR9Ptt8eQj3wkmn70o6j49KejefbsaLrtthh+ySXRunRpDJw4MTb99Kcx5MMfjpZ582Lopz4VzXPnxq4nnogB//zPsWXRohjysY/FpnnzYuhnPhObf/7z2PbggzHkYx+LzQsWxNCamth8333RunRpVHzyk7F54cLY/Ze/xKDzzost990Xwy+5JLb++tfRunRpDLv44mj99a9j+8MPx7BLLonWZctiW11dDP/3f4/WBx6I7Y8+Gm3r1sWQj388Wpcti11//nMM//d/j20PPhjbV6yIPRs3xtDPfjZ2/O53sfOPf4y2tWtj6Gc/Gzv/939j51/+Em1r18aIadNi11//GjufeCJ2Pflk7Nm4Mfbv3BnDLrmk/X29tWtj96pVsbelJfZt3x77d++OyiuuiD2bNsXelpbY09TU/vpdu2J/W1vs27Ur9u/aFft2727/PFBxcRT16BFFvXpFUY8eUVxWFj2GDInifv2ix+DB0WPw4EP+/fhw9H3Tm5L8uhQ2Ix8AAAAAAACgK5RFxNCIGH3g5ZiIOC4i+kdE9XPf8JlBTZYtioiVEfFERKyOiPUR0XDgpSki/m4YBAApGfkAAAAAAAAAh2NUtA94To6IcRExMSLiierql/kh6bXW1R1s4KKI+GtEPB4Rf4qIpyJiTURse5kfAwCdzsgHAAAAAAAAOFjHR8QpETE+Dox5/nLOOSl7utxBjIEWRMTyiHgw2q8CPR0RbV3dBUDhMfIBAAAAAAAAXkx5RJwe7WOeSRERT114YcqenLR1yZIJW5csmfAi3/XM48CWRPsI6E9h/APAYTDyAQAAAAAAACIiyqJ91DM5Is59csKL7VY4WM9cAGqprf3oC75rUUQsi/bxT31ENGU5DYA8ZeQDAAAAAAAAhWtURJwbEWc88c53vtJjqegErXV11S/yCLBFEfHQgS/rI2JTtrsAyH1GPgAAAAAAAFBYKiPioog45S/nnGPYkwOeHf788IeXP+fViyLilwe+XJ6mDIBcYuQDAAAAAAAAheHjEXHuX846y7AnD7QuW1bdumxZdURc+5xXfy8iaiPiwfCYL4CCY+QDAAAAAAAA3dexEXFZRExe/9Wvpm7hMLXMn//xlvnzP/6cV9VGxL3RfvFnXZIoALLGyAeArtD3wMuAA1+WPefLsgNvU9MFv+6sA1/uPPCy7TkvWw68tHXBrwsAAAAAkGvOi4iPPDVpkqs93djWxYsnbl28eOJzXnVvRNwdEfdHREOSKAC6jJEPAB01MCIGHfhywIGvF8dzRjtXLFgVEZHJdlhtffMr/ZpLXvDtGRHREu0nTVui/QMeIyAAAAAAIJ9dHhFXrZ0+PXUHCWz51a/et+VXv3rfc151d0TMjohF0f4XYgHIY0Y+ALyYAREx9MBLeUSUxoERzxd/lmbA00me1z1vedML/+94ZgQ0K9rHPg0RsToi1kfE3i6vAwAAAAA4dFdFxOWNN9+cuoMcsmXRonO3LFp0bkREv7FjF0XE8mgf/dQnDQPgkBj5ABS2vvG3Mc/QiLg4IuILiS7x5IBMxIteBHru+GdNtA9/1mSxCwAAAADgpVweEVc1/fCHqTvIca11ddWtdXXVTbffPvXAqxZG+6WfheHRXgB5wcgHoHAMjYiqiKiMiLKIqLn8P1dGFOaYp6MyERHzVzw7/nnu6GdrRDx14MW1HwAAAAAgW86LiI803nxzdeoQ8lPr0qXjW5cuHf+cV82IiFvDlR+AnGXkA9A9DYyI0dE+6JkaEXHVf62OMOjpLC928WfJxJMGz4qITRHxp3DpBwAAAADoGsdHxLVrp08f/4pvCR3QPHv2lObZs6cc+ObdEfGDiPhl+AuuADnDyAegexh14GVoRNR88WcF+7itlDLPGf08c+lnRrRf+Hk8fBAEAAAAABy+mU9deGFN6gi6v8333Xfu5vvuOzciot8ppyyK9tHP3dH+F10BSMTIByA/jT7wMjAiaq5btDbCqCeXZCIi7n3O473Oar/yszLaz5y2pQoDAAAAAPJSJiIub/7xjz2ai6xrXbasunXZsur1X/3qd/uNHbsoIhZGxOyIaEicBlBwjHwA8kNVRBwTEeURUfM1o558k5lf/3eDn6ciYnnCJgAAAAAgP8xc+ZnPuN5DTmitq6turaur3jBjxjcODH5+GRG3R8S6xGkABcHIByA3DY32Uc/wiKj5yi/WRBj1dBfPDH6eeaTXDdH+OK+n0iUBAAAAADloVER8v8X1HnLUM4Ofhm9969oDg58lEfG9cOEHoMsY+QDkhpKIOC7aH8F18Zd/vjrCqKe7y0RE3P1Y03MHP1dExLKI2JsqCgAAAADICZP/cu65P0wdAQfrmcFP43e+c9WBwc9PI+LWiNiStgygezHyAUinPNqHPUOnzn+6Jox6ClkmIuLWusZfR8SSc99QfkNEPBYRa5JWAQAAAAApXL/u6qsvTh0Bh+rZR3p9/esz+51yyqJof5zXnIhoS5wGkPeMfACya1S0D3su+9JC13p4UZlnrvuc9frBs6L9UV5PJG4CAAAAALJjXvOdd74vdQR0ltZly6pbly2rji996bb+mcyCiLg5Iham7gLIV0Y+AF3vmGgf9lx87X1rIgx7ODiZ+SuaMxGxZOJJg2dFxFMRsTxxEwAAAADQNQZExF1bfvWr8alDoKtsXbJkwtYlSyYc+Ob3IuL68JdcATrEyAega4yO9mHP1K//am2EYQ+HLlNbb+wDAAAAAN3YqHVf/OL3W+vqqlOHQLa0zJ//8Zb58z/eb+zYRRHxy4j4bkRsSlsFkPuMfAA6z7OP4vraLw176HQvHPs8Ee2P8gIAAAAA8texG2644UYDHwpVa11ddWtdXXXDt751bb9x4xZG+4Wf2sRZADnLyAfg8FRGxIkRcZlHcZElz459zmof+zwSESsTNwEAAAAAHXf8Uxdc8LvUEZArWpcuHd+6dOkzj6y7OSJuiIgnEyYB5BwjH4COGxgRb4iIadf8l2EPyWTmHxj7nPuG8hsiYklEbEncBAAAAAAcnGOe+tCHDHzgJbTcc89FLffcc9GBx3ndfuAFoOAZ+QAcvDdFxKgv/mxVTRj2kDsydz/WlLn7saYlF46pmB7tYx8AAAAAIHcNaJgx49upIyAfPPM4r4i4LSJ+EBFfDdd9gAJm5APw8o6JiOMi4uLvLt0QYdxD7src9mDjlRPbH+H1eEQ8kToIAAAAODh7GhtTJwBdbOcf/xg7n3gi9mzcGPt37brnwGgB6ICW2tqPttTWfrTfKacsiojvRcTdqZsAss3IB+Dv9Y2IMREx7YZfro0w7CF/ZGoPPMLr/W8svy4iFqYOAgAAAACeZ37rsmUGPnAYWpctq37Ov0fXHXhpSpgEkDXFqQMAcshxETHx8v9c+bPbH2z8VbSPewx8yEeZuY82TY2IxRFxUuIWAAAAAKDdTVsXL56YOgK6k6bbb5/653/5l40RMT8iTk3dA9DVjHyAQlcW7UOexTP/e91N965onh+GPXQPmYjIfGvJ+pkRMT51DAAAAAAUuI+23HPPRakjoLvaunjxxKc/+cnfRMR9EVGTugegq3hcF1CoRkfESf/xk5VTwqiH7i0z99GmmHjS4LKI+G1EPJk6CAAAAAAKzPHrrrnm+6kjoBC01tVVt9bVVUfEzIiYFRFfCo/yAroRIx+g0IyJiKqvLVpbE8Y9FI5MbX1zJiKWXDimYnpELEkdBAAAAIVs75YtqROALNm6eHG0rVnz9dQdUIiaf/zjmuYf/7hmwDvecW9ETI+Ix1M3ARwuj+sCCsGAiKiOiMXf+82Ga2vrm+eFgQ+FKXPbg41XRsTEiChJ3AIAAAAAheCm1mXLqlNHQCHb8qtfve+pD33od9H+KK+JiXMADotLPkB3Nioi3vCFBaumhFEPPCMzb3lTZu++/WcfO7TskYhYmToIAAAAALqpTMs991yUOgJo17psWfVzRnefi4gZCXMADomRD9AdHRcRx1173xqP5IKXcOCi1ZJPjBt2SUQ8kroHAAAACkGPiorUCUCWbKqtjd1PPXV56g7gxW2YMeMbEfGNiLg6Iq6KiJ1piwAOjsd1Ad3JmIh436z/XnfTfI/kgoOR+e7SDddH++PsAAAAAIDO843Wujqfd4Mc1/TDH17+RHX1joi4KSKGpu4BeCVGPkB3kImIxd/7zYZra417oKMysx/eeHlETEgdAgAAAADdxOjmu+6akjoCOHgt8+Zd9OR737shIu6MiGNS9wC8FI/rAvJVWUS8LSIuv+3BxgjDHjgcmbsfa4qzXj+4NCJ+EhF7UwcBAABAd9K2Zk3qBCCLNv3kJzNTNwCHZvPPfz5p889/Pqn/aafVRsSXImJ54iSA5zHyAfLNgIg45bKfrLwsDHugM2Xmr2jO7N8fZ79xVN9fRsSW1EEAAAAAkIfO2LpkiavZkOe2Ll48cevixRP7ZzILIuLqiHgwdRNAhJEPkD8GRMS4LyxYNTWMe6DLHHjk3dknjOizNCIaUvcAAABAvtu3Y0fqBCCLNv/0pxenbgA6z9YlSyZsXbJkQr9x4xZG+9jngdRNQGErTh0A8AoGRsT4aT9d9Z9zH236WRj4QJerrW+e9+Wfr54bEaNStwAAAABAHnlf67Jl1akjgM7XunTp+Kc/+cnfRMTPImJc6h6gcLnkA+SqARExbvpPXe6BRDLX3rfmts+/q+rCiFiZOgYAAADyUckRR6ROALKo+Y47LkrdAHSt1qVLx7cuXTr+wGWf6yJiSeomoLC45APkmr4Rcca0n676z7mPudwDiWWuvW/NbRFRlToEAAAAAHJcprWuzhUfKBCtS5eOX/mZzyyO9ss+pybOAQqISz5AriiNiNMu/8+Vl4dhD+SSzFd+sebOy99ddX5ErEsdAwAAAPmidNiw1AlAFjXceOPFqRuA7Hvmsk//TGZBRHwhIupTNwHdm0s+QC44/fO1Ty+a/fDG+8LAB3JR5n/X7Tgl2h+jBwAAAAA836itS5ZMSB0BpLN1yZIJT02evCIi5kfEMYlzgG7MJR8gpVMj4po7HmqMMO6BnFZb3zwvIs4+9ej+P4mIval7AAAAIJeVDBqUOgHIooaZM69M3QDkhi333z9xy/33Tzxi/PjZEXFZRKxM3QR0L0Y+QAonR8ToWx5oqAnjHsgbtfXN84qK4uySoqJ7e5QURZ/S4hjQuyQq+pWmTgMAAACAVMo2LVgwOXUEkFs2L1w4afPChZMGTphwa0R8NiK2JE4CugkjHyCbjomIE2/69QbjHshT81c015xzcnlbRCxI3QIAAAC5aNNPfpI6AciuT6cOAHLXpgULJm9asGBy+YUXXhcRn0/dA+Q/Ix8gGwZGxNu+/qu1F4dxD+S7zD3Lm+K8Nw3ZHRG/SB0DAAAAuaZnVVXqBCCLVl966fWpG4Dc13TbbVMjYmpEfCYivpU4B8hjxakDgG6tJCLO+OLPVtXes7zpP8PAB7qLzJxHNl4WEaemDgEAAACAhCamDgDyy/rrr78xIu4Lv38Ah8glH6CrjJs6/+mrwrAHuqvMLcsarplyeuUnIuKJ1DEAAACQC0qHD0+dAGRR43e+86nUDUD+aa2rq26tq6vuN27cwoi4IiKWp24C8odLPkBnOzYi3vfDZQ0GPtD9ZWbcv+67EdE3dQgAAAAAZNlJrcuWVaeOAPJX69Kl4//60Y8+FhF3RkR56h4gP7jkA3SWAdH+B/4Xh3EPFJLMIytbz+jVo/je8r49ompgz9Q9AAAAkESPIUNSJwBZtGHmzMtTNwDdw+aFCydtXrhwUvmFF14XEZ9P3QPkNpd8gM5w+rSfrvrPe5Y3/WcY+EDBmb+iuSYizkjdAQAAAABZUr5l0aJzU0cA3UvTbbdNjYj7IuK81C1A7nLJBzgcx0XEcXc81FgTxj1QyDJzHtkYn84MXx8R9aljAAAAINua7rwzdQKQXVekDgC6p9a6uurWurrqfuPGfTAi/iN8zh14ASMf4FAMiIjMrMXrPZoLeEbmW0vWz7zmzFHvjoidqWMAAAAgm3pWVaVOALJo/fXXT0ndAHRvrUuXjm9dunT8wAkTbo2Iz0TEtsRJQI4w8gE6KvOFBauuDOMe4O9lHnm69d1H9O5RO2pwz9QtAAAAANAVPp06ACgcmxYsmLxpwYLJw6ZM+VxEzEjdA6Rn5AMcrFER8abbHvRoLuCl3buiecqHTxm6MSKWpm4BAACAbCgdOTJ1ApBFLXPmnJm6ASg8G2bM+Ea/U04ZHxGfj4jlqXuAdIpTBwB5ofra+9bcNr++eV4Y+AAvL/PDZQ1XRUR56hAAAAAA6GTVrXV11akjgMLUumxZ9V8/+tHHIuL7EVGaugdIwyUf4OUcGxHHz354o+s9QEdkfrtme2ZQ7x73vrqiLHULAAAAdJkeFRWpE4AsarzppimpGwBaams/2lJb+9Hhl176iYj4XuoeILtc8gFeyvgZ/73uu7Wu9wCHYP6K5pqIODV1BwAAAAB0kmNbly4dnzoC4Bnrv/rV70bEz6L9L+0DBcIlH+CFTo6Ib8x9tCnCuAc4dJlbljVcc/V7R70nIraljgEAAIDOVjpsWOoEIIs2fP3r01M3ALxQ69Kl41uXLh0/+IILboiIS1L3AF3PyAd4RllEVN/0P+svDuMeoHNklq/advqIgT0XpA4BAAAAgMNQtnnhwkmpIwBeSvOdd17cb+zYEyPiaxGxKHUP0HWMfICIiDH/8ZOV14ZxD9DJ7lnedHHN2yufjIg/pG4BAACAztIyd27qBCC7pqYOAHglrXV11a11ddVHjB8/OyImR0Rb4iSgCxj5QGEriYjx3/vNBtd7gK6SWdm867jhA0qNfAAAAOg2SquqUicAWbR2+vQrUzcAHKzNCxdO2rxw4aQRV155fkTMSd0DdK7i1AFAMsdPnf/0r+5Z3vSfYeADdKHa+uaaiDg5dQcAAAAAHILzUgcAHIq106ffFRFzI2JA6hag87jkA4XpjBuXrL8sjHuA7Mis39I2emj/0uWpQwAAAOBwlVZWpk4Asqjplls+kroB4FBtWbTo3C2LFp1befnlH46IW1P3AIfPJR8oLKMj4n1zHt1o4ANk1YFrPm9K3QEAAAAAHTCmta6uOnUEwOFad/XVP4z2qz59U7cAh8clHygcp3/tl2unhXEPkEamYWvbqCH9ejySOgQAAAAOVWlFReoEIIs2zJx5aeoGgM6y+b77zt18333njrjyyvMjYk7qHuDQuOQD3d/QiHjfHQ81GvgASR245jMmdQcAAAAAHITKrYsXT0wdAdDZ1k6ffldE3BkRpalbgI5zyQe6t1O//PPV14RxD5AbMt//TcO1Hz116GmpQwAAAKCjSgYNSp0AZFHDN785LXUDQFfZ/POfT9r8859PqrrqqvdHxN2pe4CD55IPdF8TfvBAg4EPkItOTR0AAAAAAC+jpGXevItSRwB0tTVXXDE3Ir6bugM4eC75QPczOiJOvvuxppow8AFyT+YHDzRc85FTXPMBAAAgf7TMm5c6AciuKakDALKlZf78j/cbO/ZVEfH5iFieOAd4BUY+0L1krv/l2ivDuAfIfadGxAOpIwAAAOBg9KyqSp0AZNHqSy+9PnUDQDa11tVVt9bVVQ/52Me+FBHTU/cAL83IB7qPibc92DglDHyA3Je5ZVnDNZPHVpyWOgQAAAAAXmBi6gCAVDZ+//vT+mcyJ0fEhyOiKXUP8PeMfCD/jY6Ik+ct93guIO+Mi4ilqSMAAADg5ZRWVqZOALKo8eabP5W6ASClrUuWTNi6ZMnGEV/4woURcXvqHuD5jHwgv4372qK1V4VxD5B/MrfWNV514RjXfAAAAADIGce3LltWnToCIBes/fKXbxs4YcLp0X7VB8gRRj6Qvyb8cFnDxWHgA+S3TEQsSR0BAAAAL6bHsGGpE4Asapg167LUDQC5ZNOCBZP7nXJKVUR8KiKeTN0DGPlAPiqPiMzdj3k8F5D3Mrc92HjlB9/img8AAAAAyQ3YvHDhpNQRALmmddmy6tZly/5cefnlH46IW1P3QKEz8oH8cvyVP1t9Yxj3AN3L6RFxf+oIAAAAeK7m2bNTJwDZdXnqAIBctu7qq3846Oyzx0TEJ1O3QCEz8oH8cfqNS9ZPCwMfoHvJ3P5Q47QPvKXi/hOr+qRuAQAAgGf1PPLI1AlAFq27+uqpqRsAcl3LvHkX9TvllFeHx3dBMsWpA4CDMuH2BxsNfIDu7PTUAQAAAAAUrMmpAwDyReuyZdX/d955f46ID6ZugULkkg/ktoERcfo9y5tqwsAH6L4ydzzUOO26s45aEhF7U8cAAABAaWVl6gQgi5rvuGNS6gaAfLP2y1++bfCkSW+IiM+lboFCYuQDuevY6T9d9d0w7gEKQ6Z+9bbTT6jqsyh1CAAAAAAFJdNaV1edOgIgHzXPnj2l/2mnvSoi3h8RbYlzoCAY+UBuOnXG/euuCQMfoIDc+fDGy79aNWpx+EAAAACAhEqHDUudAGRRw403Xpy6ASCfbV28eOKanTt/NuQTn/h8RCxP3QPdnZEP5J7qHzzQcHkY+ACFJ1O/evvpJ1T1+UXqEAAAAAAKwqitS5ZMSB0BkO9a6+qqW+vqqodfeuknIuJ7qXugOzPygdwyYfbDGy8OAx+gQN31yMbLTqgatSQidqZuAQAAoPCUDBqUOgHIooaZM69M3QDQnaz/6le/O+icc94QEZ9M3QLdlZEP5I733f1YU00Y+ACFLfPbNdszJ4xwzQcAAACALlW2acGCyakjALqblnvuuaj/aacNj4izUrdAd2TkA+kNjIjT569oNvABiIg5j2y87IT3jloaEdtStwAAAFA4WubOTZ0AZNfU1AEA3dXWxYsn9hs79r6I+FhErEzdA92JkQ+kNfqLP1v1wzDuAXiuzO/WbB/3jyN6u+YDAABA1pRWVaVOALJo7fTpHtUF0IVa6+qqW8855+kjZ858R0Tcn7oHuovi1AFQwE6+/pdrDXwAXsScRzdeFhEDUncAAAAA0C2dlzoAoFCs+uxnfxURH0/dAd2FSz6Qxrib/mf9VWHgA/BSMr9bu33cP1b2WZg6BAAAgO6v11FHpU4Asqjx5ps/kroBoJCsv/ba7w6eNOl1EfG51C2Q71zygeyr/uGyBgMfgFcw99GmqRExMHUHAAAAAN3KSa11ddWpIwAKTfPs2VMi4s7UHZDvXPKB7Bo/++GNU8PAB+BgZP537fZTj6vs7ZoPAAAAXabHkCGpE4As2jBz5uWpGwAK1eaf/3xS/0ymf0S8N3UL5CuXfCB7Jhy4SmHgA3CQ5j7WNDUiylN3AAAAANAtlG9ZtOjc1BEAhWzrkiUTIuK+cMkfDolLPpAdE+9Z3jQlDHwAOirz+3U7Tj1ueO8FqUMAAADofpru9MQIKDBXpA4AIKJ12bLqdV/+8tyKf/u3z0TEE6l7IJ8Y+UDXKomIM+9d0VwTBj4Ah+Tux5ounjZ+5AMR0ZS6BQAAgO6lZ1VV6gQgi9Zff/2U1A0AtGutq6turav706gbbzwtIpak7oF8YeQDXaf0gb9snTC/vnle6hCAPJf5/bodp752mGs+AAAAAByyT6cOAODvrfzMZxaPuPLK8yNiTuoWyAdGPtA1+tY91XpGrYEPQKe4Z3nTxVe8e+SDEdGQugUAAIDuoXTkyNQJQBa1zJlzZuoGAF7c2unT7xr++c/3j4jvpW6BXGfkA51v4MNPt55u4APQqTJ/3LBjzLHDylzzAQAAAKCjqlvr6qpTRwDw0tZfe+13h02Z0jciZqRugVxm5AOdq3z5qm0ZAx+AznfP8qaL/+PdVY9ExLrULQAAAOS3HhUVqROALGq86aYpqRsAeGUbZsz4xtBPf7pnRFyXugVylZEPdJ4B9au3G/gAdJ3MnzbsHPOairLa1CEAAAAA5I1jW5cuHZ86AoCD0/Ctb1075GMf6xsR01O3QC4y8oHO0fexVdveaeAD0LXmLW+acum7qh6OiDWpWwAAAMhPPcrLUycAWdQwa5Y/JAbIMxu///1p5R/8YFlEfD51C+Sa4tQB0A2UPfx06xkGPgBZkXmiYceb90eEFy9eCucFAAAADtGAzQsXTkodAUDHNd1++9SImJm6A3KNSz5weEoe+mvreAMfgOy5d0XzlM+/q+qxiFiZugUAAID80jx7duoEILsuTx0AwKFr+fGPawb/679GRHw2dQvkCiMfeBG79uyL7bv3xbbd+2LH7n2xa8++2L13f+zZuz/27d//t79Rvj/OnG/gA5BtmScadrzpmCFlRj4AAAB0SM8jj0ydAGTRuquvnpq6AYDD0/zjH9cMPv/8fRHxudQtkAs8rgsO3fvm1zfXpI4AKETzVzTXRMTo1B0AAAAA5KzJqQMA6BzNd901JSKuTd0BucAlHzg07zvwB8yZ1CEABSrz5MadJx89pOyp1CEAAADkh55HHZU6AciipltumZS6AYDO03T77VOHfOxjOyNieuoWSMklH+i4iQY+AOkd+L34mNQdAAAAAOScMa11ddWpIwDoXBu///1pEXF56g5IySUf6JgJ965onhIGPgC5IPN/jTtPHD2k15OpQwAAAMhtpRUVqROALNowc+alqRsA6BqNN9981bApU7ZFxIzULZCCSz5w8M64Z3nTxWHgA5Az5te75gMAAADA81RuXbx4YuoIALrOhhkzvhER56bugBRc8oGDk5nzyMbLwsAHINdkntq468RRg13zAQAA4MWVDBqUOgHIooZvfnNa6gYAut6aK66Ye+SMGe+KiEWpWyCbXPKBVzbmtgcbrwwDH4CcdOCaz3GpOwAAAABIrqRl3ryLUkcAkB2rpky5LyKOT90B2eSSD7y84773mw3XhoEPQC7LrGzeddyRg3r+IXUIAAAAuaVl3rzUCUB2TUkdAEB2NX7721+vvOKK8yOiKXULZIORD7y0qln/ve6mMPAByHnz65trak4b/oeIMPQBAADgWT2rqlInAFm0+tJLr0/dAEB2tdbVVa+7+uq7inr1elePIUOix+DB0evoo6PXq1+dOg26hJEPvLgBf1i/Y0wY+ADki8zKlt3HVQ10zQcAAACgQE1MHQBAGq3LllX3P+20+RFxVuoW6GpGPvD3Sh5due2dtfXNbvkC5JHa+uaaT2eG/yUi6lO3AAAAkF7p8OGpE4AsavzOdz6VugGAdLYuXjxx0Dnn3BQRn0zdAl3JyIckWnftTZ3wPC3b90Trrn2xY/e+2L133wQDH4C8lFmzaferK4/oaeQDAAAAUFhOal22rDp1BABptdxzz0UVn/jEuoj4UuoW6CpGPvB8Z9y7onlK6ggADk1tfXPNJ/9p+FMRsTx1CwAAAOn0GDIkdQKQRRtmzrw8dQMAuaHxu9+9cuRXv/rbiKhN3QJdwcgH/mbcnEc3XhYRmdQhAByyzLrNu0cPH1Bq5AMAAABQGMq3LFp0buoIAHLH6ksvnf/qu+8+KiJWpm6BzmbkA+2O/+GyhqvCwAcg79XWN9dc9LZhrvkAAAAUqKY770ydAGTXFakDAMg9G77+9e+X9O//rp5HHx29Tzgheh93XOok6BRGPhBR/s3F628MAx+A7iKzfkvb6KH9XfMBAAAoRL2OPjp1ApBF666+ekrqBgByT+uyZdVHvOtdcyPi/alboDMZ+ZBEv14lSX/9dZt3R8v2PbF9975o27s/EwY+AN1KbX1zzSfGDVsZEY+kbgEAAACgy0xOHQBA7tp8333nVlx00eURcXXqFugsRj4UuvHz65trUkcA0OkyDVvbRlX0KzXyAQAAKCCllZWpE4Asar7jjkmpGwDIbY0333zVqG99a0lELE3dAp2hOHUAJDRu7mNNU8MVH4BuqbZ9xDkmdQcAAAAAXSLTWldXnToCgNzXfPvt0yKiNHUHdAaXfChUx95a13hVGPgAdGeZ7/1mw7UfPXXoaalDAAAA6Hqlw4alTgCyqOHGGy9O3QBAfmitq6ted9VVc3u99rVn9Rs7ttN+3t6ve12n/VxwsFzyoRCVPNW06/gw8AEoFKemDgAAAACgU43aumTJhNQRAOSPLfffPzEiLkvdAYfLJR+SWL+lLcmv27StLVp37ZtQW988L0kAANmW+cEDDdd85BTXfAAAALqzkkGDUicAWdQwc+aVqRsAyD+N3/72Nf3Gjl0QEY+nboFDZeRDocnMW940JXUEAFl3akQ8kDoCAAAAgMNWtmnBgsmpIwDIT4033fT1nqNGvavf296WOgUOiZEPheSYH9U1Xhke0wVQaDK3LGu4ZvLYitNShwAAAND5WubOTZ0AZNfU1AEA5K/WZcuqB48aNTMiPpu6BQ6FkQ9JDOpTkrVfa/Wm3dGybU/s3rv/xDDwAShk4yJiaeoIAAAAOldpVVXqBCCL1k6f7lFdAByW5h//uKbf2952b0QsSd0CHWXkQ6EYX1vfXJM6AoBkMrfWNV71Idd8AAAAAPLZeakDAOgemu+44/KeRx+95IgzzkidAh1i5EMheNPcx5qmhis+ALT/t8AyHwAAoJsoraxMnQBkUdMtt3wkdQMA3UNrXV314KOP/kZEfC51C3SEkQ/d3YDv/HrD9WHgA0BE5kd1jVd+cIxrPgAAAAB5aExrXV116ggAuo/m2bOnHHHGGT+IiMdTt8DBMvIhif37u/7XeLp5V7Rs33N6GPgA8HynR8T9qSMAAAA4PKUVFakTgCzaMHPmpakbAOh+Gm+++et93vzmdw2cMCF1ChwUIx+6s1PvXdE8JXUEADklc/uDjdM++JaK+0+o6pO6BQAAAICDU7l18eKJqSMA6H5aly2r7vPmN18cETekboGDYeRDdzXgBw80XBOu+ADw4lzzAQAAyGNNd96ZOgHIrmmpAwDovhpmzbp+4IQJ34qInalb4JUY+ZBEj5KiLvu5/9K402O6AHg5mdsfapx23VlHLYmIvaljAAAA6Lher3pV6gQgi9Zff/1FqRsA6N4aZs26adDZZ3+4Qz/ohBO6qAZempEP3ZHHdAHwSjL1q7edfmJV30WpQwAAAAB4WZ9OHQBA97dpwYLJg84+e0ZE1KdugZdj5EN3U+YxXQAcjDsf3nj5iVV9F0dEW+oWAAAADl7pyJGpE4Asapkz58zUDQAUhsbvf/+aQeee+57UHfByjHxIYv3m3V3y867b0lYdBj4AHJxM/Zptp50woo9rPgAAAAC5qbq1rq46dQQAhaF16dLxg8499/SIuD91C7wUIx+6k+Pufqzp4tQRAOSP2Q9vvPwrZ476dUTsTN0CAADAK+tRUZE6AciixptumpK6AYDC0jJnzqUD3v1uIx9ylpEPSQzuW9qpP9+TjTujddfe48IVHwA6JvPbNdszx4/o84vUIQAAAAA8z7GtS5eOTx0BQGFpXbasesC7331eRMxJ3QIvxsiH7uL02vrmmtQRAOSfux7ZeNnV7x21NCK2pW4BAADgpfUoL0+dAGRRw6xZ01M3AFCYtvz85x854swzjXzISUY+dAcD73iocVq44gPAocn8bs32cceP6O2aDwAAAEBuGLB54cJJqSMAKEytdXXVR5x55sSIqE2cAn/HyIckWrbv6bSfa/Wm3aeFgQ8Ah2HOoxsvu2rEka75AAAA5Kjm2bNTJwDZdXnqAAAK2+af/ORTg84/vzZ1B7yQkQ/57rh5y5umpI4AIO9lfrt2e+b4yj4LU4cAAADw93oeeWTqBCCL1l199dTUDQAUtta6uupB559/ekTcn7oFnsvIhyS27drbKT/Pxm17jgtXfADoBHMfbZp6/L/0WRoRW1K3AAAAABSwyakDACAiomXOnEsrPvMZIx9yipEP+WxMbX1zTeoIALqNzONrt497nWs+AAAAOaW0sjJ1ApBFzXfcMSl1AwBERLQuW1Zd8ZnPHBsRT6RugWcY+ZDEqyvKDuvH/37djrj9ocZrwxUfADrR3Meapn7xPX0eiIhNqVsAAAAAClCmta6uOnUEADyj+c47pw+/5JILUnfAM4x8yFenpw4AoFvK/O+67W87bnjvBalDAAAAiCgdPjx1ApBFDd/85sWpGwDguTYvXDhp+CWXTI6IttQtEGHkQ34qu/2hxmnhig8AXeDux5ounjZ+5AMR0ZS6BQAAAKCAjNq6ZMmE1BEA8EIt8+fXRMQNL3x979e9LkENhc7IhyT27T/0H/u7tdszYeADQNfJ/H7djlNf65oPAABAUj2GDEmdAGRRwze/eVnqBgB4MdsffviMoZ/73N+NfCCF4tQB0EF95zyy0Tv6AHSpe5Y3XRwRQ1N3AAAAABSIkpZ58y5KHQEAL6a1rq46Ikan7oAIl3zIM79bu31cuOIDQNfL/HH9jjHHDitzzQcAACCBlnnzUicA2TUldQAAvJxNtbU1EfG5575uQMYfW5N9Rj7kE1d8AMiae5Y3Xfwf7656JCLWpW4BAAAoND2rqlInAFm0+tJLr0/dAAAvp/muu6aM/tGPPvfKbwldy8iHJHoUF3X4xyxftc0VHwCyKfOnDTvHHDu0rDZ1CAAAAEA3NjF1AAAcpOMj4vHUERQ2Ix/yRemcR13xASC75i1vmnLZGVUPR8Sa1C0AAACFonT48NQJQBY1fuc7n0rdAAAHY/MvfvHReM4ju44444yENRQqIx+S+N3a7R39IW8LV3wAyL7MnzbsePNrhvY28gEAAADofCe1LltWnToCAA5G8+zZU45ZsMAju0jKyIckevXo2OO6fvBAw7QuSgGAl3XviuYpn39X1WMRsTJ1CwAAQHfXY8iQ1AlAFm2YOfPy1A0A0EHlEdGUOoLCZeRDPjg1dQAABS3zRMOONx1TUWbkAwAAANB5yrcsWnRu6ggA6IjtDz00PiJuj4jo9+Y3J66hEBn5kET/spKDftsZ96+7JjyqC4CE5q9orvn36hHLI+Kp1C0AAADdVdOdd6ZOALLritQBANBRW3/96/fFgZHP0E9/OnENhcjIh1x3bOoAAIiIzJONO08+ekiZkQ8AAEAX6VlVlToByKL1118/JXUDAHTU1sWLJ77mZz9LnUEBK04dQGEa2LvHQb083bzr+HDFB4AcMH9Fc01EHJO6AwAAAKAbcPoAgHw2MHUAhcslH3LZwAN/oAoAuSDzf407Txw9pNeTqUMAAAC6m9KRI1MnAFnUMmfOmakbAOBQ7fjTn8ZExC/6vvGNqVMoQEY+JPHHDTsO5s3GhCs+AOSQ+fXNNf/vHZW/jQhDHwAAAIBDU91aV1edOgIADtWOFStOj4hfxKRJqVMoQEY+JDG0f+krvs2s/153WRZSAKAjMk9t3HXiUYNd8wEAAOgsPauqUicAWbRh5swpqRsA4HDseuKJk1M3ULiKUwfASzgudQAAvJj59c01EXFs6g4AAACAPDSqdenS8akjAOBwtNbVVbfW1aXOoEC55EMSwwe8/CWfh59uPS48qguA3JR5unnX8UcO7vVE6hAAAIB8VzJoUOoEIIsaZs68MnUDAHSGV8+fnzqBAuWSD7mobP6K5prUEQDwUg5c83F1DgAAAODglW1asGBy6ggA6CSVqQMoTC75kMSTjTtf7rvfEK74AJDbMquadx1XNbDnH1KHAAAA5KuWuXNTJwDZNTV1AAB0lr3NzcMjYl3qDgqPkQ9JjC7v9ZLf9+jKbcOzmAIAh2R+fXPNZzLDn4iIx1O3AAAA5KPSqqrUCUAWrZ0+3aO6AOg29jQ0HBURy1N3UHiMfMg1A2rrPaoLgLyQWb1p97FVA3sa+QAAAAC8vPNSBwBAZ9q9du2rUzdQmIx8SOL/Nu56qe86MTyqC4A8UVvfXPPpzPC/RER96hYAAIB8UlpZmToByKKmW275SOoGAOhMe5qaRqZuoDAZ+ZDEMRVlL/r6h59uHZrlFAA4HJk1m3a/unJAqZEPAAAAwIsb01pXV506AgA6076tWwembqAwGfmQS/p6VBcA+aa2vrnmk28b9lR49i4AAMBBKa2oSJ0AZNGGmTMvTd0AAJ1tr5EPiRj5kMTKlhd9XNdx4VFdAOSfzLotbaOHDSg18gEAAAB4vsqtixdPTB0BAJ1t/86dfVM3UJiMfEiiYWvbi716VLY7AKAz1NY31/x/bxu2MiIeSd0CAACQy0oGDUqdAGRRwze/OS11AwBAd2LkQxLHDCn7u9d97ZdrPaoLgHyV2bClbVRFv1IjHwAAAIB2JS3z5l2UOgIAoDsx8iFXjE4dAACHo7a+uebjbx22JiIeTN0CAACQi1rmzUudAGTXlNQBANBlevR40UfXQFcz8iGJdVv+7ve80RGRSZACAJ0l09jaVjWkr3evAAAAXkzPo45KnQBk0epLLrk+dQMAdJUegwY1pG6gMBWnDqAwte7a+8KXgambAOBw1dY310TEmNQdAAAAAImNTx0AAF2px7BhK1M3UJj8VXOSeE1F2fO+/bVfrq1JlAIAnSnz/Qcarv3IKUNPSx0CAACQS0orK1MnAFnUeNNNn07dAABdqXToUCMfknDJh1wwOnUAAHSyU1MHAAAAACRybOvSpS75ANCtlQwevC51A4XJJR+S2LC17bnfHBURmUQpANDZMrcsa7jmw675AAAAREREj/Ly1AlAFjXMmjU9dQMAdDWXfEjFyIcktu7c+9xv+igfgO5oXEQsTR0BAAAAkEUDNi9cOCl1BAB0tdLhw59K3UBhMvIhiTeO6vvs169YsKomYQoAdIXMD5c1XPWhsRWnpQ4BAABIqXn27NQJQHZdnjoAALJkW+oACpORD6n1feU3AYC8lYmIJakjAAAAUul55JGpE4AsWnf11VNTNwBAV+s3duyitdOmxTG1talTKEBGPiSxsXXPM1+tivY/AAWA7ibzo7rGKy8c45oPAAAAUBAmpw4AgGworaz8a+oGCpeRD0m07Hh25FOZsgMAssA1HwAAoCCVVvrUHxSS5jvumJS6AQCyoe9b3rIwdQOFy8iHJLbs3PvMV8tTdgBAF8vc9mDjlR98S8VpJ47sk7oFAAAAoKtkWuvqqlNHAEA2lL32tQ+mbqBwGfmQxPwVzc98tSZlBwBkyekRcX/qCAAAgGwpHTYsdQKQRQ033nhx6gYAyKJ1qQMoXMWpAyhMV004Mq6acGTqDADIhsztDzVOi4iS1CEAAAAAXWDU1iVLJqSOAIBsGFBdfXfDt78dDd/+duoUCpRLPqTUN3UAAGRJZsXqbaefVNV3UeoQAACArlYyaFDqBCCLGmbOvDJ1AwBky4B3vGN26gYKm5EPSWzbvS8iYmBEZNKWAEB23PnQxstPOqvv/RGxN3ULAAAAQCcp27RgweTUEQCQLX3HjFmQuoHCZuRDEq279kZE+Cs9ABSSzIrV204/YUQf13ygmyspLkqdAACQTMvcuakTgOyamjoAALKl37hxC8Nf5CUxIx+SaN317CUfACgYsx/eePlXzhz164jYmboFAACgK/Q6+ujUCUAWrb70Uo/qAqBgDHjXu27f+utfP/vt3scdl7CGQmXkQxLb2i/5DEjdAQBZlvntmu2Z40f0+UXqEKBrlJa44gMAABSMiakDACDL5qQOACMfkti9d39ERFnqDgDItrse2XjZ1e8dtTQitqVuAQAA6Eylw4enTgCyqPE73/lU6gYAyJaBEybcuv3hh5//yk98Ik0MBc3IhyRq65sjImpSdwBAApnfrd0+7vjK3q75QLfkkg8AAFAQTmpdtqw6dQQAZMugc8+9IXUDRBj5AABk3ZxHNl521YQjXfMBAAC6jR5DhqROALJow8yZl6duAIBs6Tdu3MKIeDx1B0QY+QAApJD53drtmeNH9FmYOgToPL16FKdOAAAAyIbyLYsWnZs6AgCyZdA558zY09ycOgMiwsgHACCJHz/aNPX4EX2WRsSW1C0AAACHo+nOO1MnANl1ReoAAMiWfmPHLoqIRak74BlGPgAAaWR+t3b7uNcNd80HAADIbz2rqlInAFm0/vrrp6RuAIBs6f+Od8ze09iYOgOe5Z48AEAicx9tmhoRA1N3AAAAABykT6cOAIAsuzV1ADyXSz4kcd1ZR8XU+U+nzgCA1DK/X7f91NcO7+2aD+S5fr1KUicAACRROnJk6gQgi1rmzDkzdQMAZEv5hRdet3vVqtQZ8DxGPqTiT0EAICLmPtY0ddr4kQ9GRFPqFgAAAICXUd1aV1edOgIAsmXwpElXp26AFzLyAQBIK/OH9TtOfe2w3gtShwAAAHREj4qK1AlAFjXedNOU1A0AkC1HjB8/OyK2pO6AFzLyIZW9qQMAIFfc/VjTxV/455EPRkRD6hYAAACAF3Fs69Kl41NHAEC2DL7ggiv3NDnAT+4x8iGJqfOfTp0AALkk84f1O8b8w7Ay13wgDx3R24dVAEDh6VFenjoByKKGWbOmp24AgGzpN27cwoh4InUHvBifjQYAyAH3LG+6+PJ3Vz0SEetStwAAAAA8x4DNCxdOSh0BANky6JxzZuxpbEydAS/KyAcAIDdk/rhh55hjh5bVpg4BAAB4OS333JM6Aciui1MHAEC29Bs7dlFELErdAS/FyAcAIEfMW9405bIzqh6OiDWpWwAAAF5KzyOPTJ0AZNHa6dOnpW4AgGzpN27cT9pWr06dAS/JyAcAIHdk/rRhx5tfM7S3kQ/kifK+PqQCAAC6tfNSBwBAln0rdQC8HJ+RBgDIIfeuaJ7y+XdVPRYRK1O3AAAAvFBpZWXqBCCLmm655SOpGwAgWwaff/6M3Wv8HVxym5EPSZz1+sEREbPmr2jOpG4BgByT+XPDjjccU1Fm5AMAAACkNKa1rq46dQQAZEv5hz40PXUDvBIjH5LoXVocEbE1dQcA5KJ7VzRPmVo9wjUfAAAgp5RWVKROALJow8yZl6ZuAIBsOWL8+NkRsSV1B7wSIx+S6NuzJMJvkgDwUjJ/btz5plcPcc0HctnQ/qWpEwAAALpK5dbFiyemjgCAbBl8wQVX7mlqSp0Br8jIhyT69SqOiGhJ3QEAuWr+iuaaS945YnlEPJW6BQAAoGTQoNQJQBY1fPOb01I3AEC29Bs3bmFEPJG6Aw6GkQ9J9C8riYhoioglEZFJWwMAOSnzl407Tx5dXmbkAwAAAGRTScu8eReljgCAbBl0zjkz9jQ2ps6Ag2LkQ0runQHAy5i/ornm/71jxG8j4snULQAAQOFqmTcvdQKQXVNSBwBAtvQbO3ZRRCxK3QEHy8iHJL60cHXqBADIB5mnNu488ajyXkY+kGNGHNEzdQIAQNb0rKpKnQBk0epLL70+dQMAZEu/ceN+0rban12TP4pTB1CYzjpp8DMvs1K3AEAum1/fXBMRx6buAAAAAArCxNQBAJBl30odAB3hkg9J9CsreearmxJmAEA+yDzdtOv4UYN7PZE6BAAAKDylw4enTgCyqPE73/lU6gYAyJbB558/Y/eaNakzoEOMfEhiUJ9n/19vXcoOAMgH8+ubaz779so/RMQfUrcAAAAA3dZJrcuWVaeOAIBsKb/ggqtSN0BHGfmQRHnf5418lkREJl0NAOS8zMrmXceNHNTTyAdywJGDeqVOAADIih6u+EBB2XDDDZenbgCAbBlQXX13RDSl7oCOMvIhtU2pAwAgH8yvb675t9OGPxERj6duAQAAALqdAVsWLTo3dQQAZEv5BRdcvWfjxtQZ0GFGPiSxfNW2Z78+8aTBs2rrm13yAYCXl1nVsvvYqoE9jXwAAIAu1zx7duoEILtc8QGgYPQ75ZRFEVGfugMOhZEPSRzRu+S533QGDQAOQm19c82nM8P/Ej74AAAAuljPI49MnQBk0bqrr56augEAsmXgmWd+u239+tQZcEiMfEhixBE9n/vNJyNiSUS45gMALy+zZtPuV1cOKDXygURGDylLnQAAANDZJqcOAIAsq00dAIfKyIdcsCZ1AADki9r65ppPvm3YUxGxPHULAADQfW0856NR+ZuFqTOALGi+445JqRsAIFuG/tu/XbJ7jT+eJn8Z+ZDEH9fveN63zzpp8Kz59c0u+QDAK8us29I2etiAUiMfAAAA4HBlWuvqqlNHAEC2DDr77BmpG+BwGPmQxJB+pS98lbkkAByk2vrmmv/vbcNWRsQjqVsAAIDuq3TYsNQJQBdruPHGi1M3AEC2DDr77JsjYm/qDjgcRj4kMWpwzxe+6g8RsSQiXPMBgFeW2bClbdTQ/qVGPpBFx1SUpU4AAADoTKO2LlkyIXUEAGRL+Qc+8KW9LS2pM+CwGPmQK7ZMPGnwrFqP7AKAg1Jb31zziXGu+QAAAF1n5TFvjNFN/5c6A+giDTNnXpm6AQCypf9pp9VGxLrUHXC4jHxI4s8NO//udQPKSpoSpABAvso0bG0bNaRfDyMfAAAAoKPKNi1YMDl1BABkS/nkyV/cs3lz6gw4bEY+JDF6SK8Xe/Xj4ZFdAHDQauubaz721qFrIuLB1C0AAED31DJ3buoEoGtMTR0AANnS75RTFkVEfeoO6AxGPuSSJo/sAoAOyXz/Nw3XfvTUoaelDoHu7h+G9U6dAACQxKZPXhoV/3l76gygk62dPt2jugAoGAPPPPPbe9avT50BncLIhyRWtex+0dcP7tvD764A0HGnRsQDqSMAAACAvHBe6gAAyLLa1AHQWYx8SOKYirKX+q7HwiO7AKAjMj94oOGaj5zimg8AANA1SisrUycAnajplls+kroBALJl6L/92yW716xJnQGdxsiHXLPzfa8fPOPeFR7ZBQAd5JoPAAAA8ErGtNbVVaeOAIBsGXT22TNSN0BnMvIhicatbS/5fUcN7vX7cM0HADoic8uyhmsmj604LXUIdEevq+yTOgEAIKm1b35nvGrN71NnAJ1gw8yZF6duAIBsGXT22TdHxN7UHdCZjHzIRU+kDgCAPDUuIpamjgAAAAByUvmWRYvOTR0BANlS/oEPfGlvS0vqDOhURj4k0bJ9z8t+/+SxFVfcWtd4VbjmAwAHK3NrXeNVF45xzQcAAOh8TXfemToBOHxXpA4AgGzpf9pptRGxLnUHdDYjH3KVKwQAcGgy0f7YSwAAgE6zderVUX7nt1NnAIdh/fXXT0ndAADZMnjSpK+2NTamzoBOZ+RDEjvb9r/i25z3xiFfmfPoRpd8AODgZW57sPHKD77FNR/oLCdU9UmdAAAA0Bk+nToAALKl39ixiyLiwdQd0BWMfEjidZW9D+bNlkX7JQJDHwDomNMj4v7UEQAAQPdSOnJk6gTgELXMmXNm6gYAyJYB//zPt7St86QuuicjH3LZlve/ofy6uY81GfkAwMHL3P5Q47QPvKXi/hNdIAEAAAAiqlvr6qpTRwBAFs1JHQBdxciHJPbuf+XHdUVEHFfZ+8FwzQcADoVrPgAAQKdan3lvjPz9stQZQAc13nTTlNQNAJAtFZ/4xPS2NWtSZ0CXMfIh1zW55gMAHZa546HGadedddSSiNibOgYAAABI5tjWpUvHp44AgGwZ9P73X5e6AbqSkQ9JlBQVHfTbHj+iz9K5jzW55gMAHZOpX73t9BOq+ixKHQL5qrgD77MCABSKHuXlqROADmiYNWt66gYAyJaBEybcGhE7U3dAVzLyIR9sOe9NQ74y55GNRj4A0AF3Przx8q9WjVocEW2pWwAAAICsG7B54cJJqSMAIFvKL7xw+t6WltQZ0KWMfEiiV4/iDr39ySP73j/nkY2u+QBAx2TqV28//YSqPr9IHQL5qNghHwCAv/PXYcfGgG98MXUGcHAuTx0AANnSP5NZEBErU3dAVzPyIV+0TR5bccWtdY1XhaEPABy0ux7ZeNkJVaOWhBOlAABAJ+l55JGpE4CDsO7qq6embgCAbBl07rk3tG3YkDoDupyRD/lk6cSTBs+qrW828gGAg5f57ZrtmRNGuOYDHVFa4owPAACQ1yanDgCAbOk3duyiiFiSugOywciHJP7a1PFjAr1Li6N3afFT0f4btKEPABykOY9svOyE945aGhHbUrcAAAD5b+M5H40RD/8ydQbwMppuuWVS6gYAyJYB1dW373HFhwJh5EO+We6aDwB0WOZ3a7aP+8cRvV3zgYPmkg8AAJC3xrTW1VWnjgCALLo9dQBki5EPSRQXH/ofmlQN7PmXcM0HADpkzqMbL/vyiCOXRcSW1C0AAED+K62oSJ0AvIQNM2demroBALKl4hOfmN7mig8FxMiHfFTvmg8AdFjmd2u3j/vHyj4LU4dArutdWpw6AQAA4FBVbl28eGLqCADIlkHvf/91qRsgm4x8SOIwDvlERMSRg3o+Ea75AECHzH20aeqV/9LngYjYlLoFAADIb0+/6qQ4evPK1BnACzR885vTUjcAQLYMnDDh1ojYmboDssnIh3z1+FknDZ413zUfAOiIzP+u3X7qcZW9XfMBAACA7qekZd68i1JHAEC2lF944fS9LS2pMyCrjHxIorjoME/5RMSowb3+EK75AECHzH2saer094x8MCKaUrcAAAD5rWXevNQJwPNNSR0AANnSP5NZEBFOS1JwjHzIZ39wzQcAOizz+3U7Tj1ueO8FqUMgF/XrVZI6AQAgb7R85HMx7BdzU2cAB6y+9NLrUzcAQLYMOvfcG9o2bEidAVlXnDqAwlRU1DkvR5X3ejzar/kAAAfp7seaLo6I8tQdAAAAQKeZmDoAALKl39ixi8KfEVOgXPIh3z3hmg8AdFjm9+t2nPraYa75AAAAh6d0+PDUCUBENH7nO59K3QAA2dL/He+Y3bZuXeoMSMIlH5IoLirqtJfRQ8p+G5aaANAh9yxvujgihqbuAAAAAA7bSa3LllWnjgCALLo1dQCk4pIP3cGTZ71+8Kz5K1zzAYAOyPxxw44xrxla5poPHDCojw+PAAA6avVJ/xSvWvP71BlQ0DbMnHl56gYAyJbyCy+8bveqVakzIBmfxSaJkqLO/fmOGVK2PNqv+Rj6AMBBumd508WXnVH1WESsSd0CAAAAHJLyLYsWnZs6AgCyZfCkSVenboCUjHzoLp5yzQcAOizzRMPON7+moszIBwAAOGRNd96ZOgEK2RWpAwAgW44YP352RGxJ3QEpGfmQRHFxJ5/yiYhjh/Z+JFzzAYAOmbe8acql76p6OFzzAQAADtHWqVdH+eybUmdAQVr/ta9NSd0AANky+IILrtzT1JQ6A5Iy8qE7Wfm+1w+eca9rPgDQEZknGna8+TVDexv5UNDK+/rQCMgZAyKif0T0PfDS+8CXpRFRduBtajrx15t14MudB162Hfhyy4GvbznwbQAg91yUOgAAsqXfuHELI+KJ1B2Qms9kk0Tn3/Fpd+zQ3g+Haz4A0CH3rmie8vl3VT0WEStTtwBAN1d+4GVQ/G3M87zBzrSfrorI4se0tfWv+Bdllrzg27MiYmtEtETEpohoCKfSgYjoedRRqROg4DTfccf7UjcAQLYMOuecGXsaG1NnQHJGPnQ3a84+uXzGvOVNRj4AcPAyTzTseNMxQ8qMfADg8JRExNB4/phnyjPf+aWFqyPy7y+lPK93/t+Pgp47ApoV7cOfdQdeNnVlGAAUuExrXV116ggAyIZ+Y8cuiohFqTsgFxj5kERxcdf93P8wrOzBcM0HADpk/ormmn9/54jlEfFU6hYAyBNDI6IyIoZH++O0aqbOfzqi8D4Wffb/3hcMgJ4Z/8yK9sd+rY+Ip8PwB7qtdW8dH6OefDR1BhSMhhtvvDh1AwBkS79x437Stnp16gzICUY+dEfrzjm5/IZ7XPMBgI7IPLlx58lHDykz8qHgDOtfmjoByG0lEVEV7YOeyjhwmeeq/8rLqzzZlIn4u8eBPXf4syYinoyIpix3AUB3MGrrkiUTUkcAQBZ9K3UA5AojH5IoLirq0p//tcN7u+YDAB00f0VzzcXvHPHbaP8DNwAoVEMjYlS0D3ou/vd7C/I6T1fJRETMX/Hs8OeZ0c+MaL/y85eI2JL9LKCzlAwalDoBCkLDzJlXpm4AgGwZfP75M3avWZM6A3KGkQ/dVYNrPgDQYZn/a9x54ughvYx8ACgkoyJidESUR0TNl3/uQk8WZSIi7v370c8NEfGniHgiRRQA5LiyTQsWTE4dAQDZUv6hD01P3QC5xMiHJIq79pBPRES8rrL3A7HcNR8A6Ij59c01/+8dla75ANCdjT7wMjAiaq69b02EjxtzRSYi4u7HmjLx/Ed7/SUi6lNFAQfvqfKjY+BNX02dAd3d1NQBAJAtR4wfPztcfIXnMfKhO2s69w3lNxz45CAAcHAyT23cdeKowa75UBiqBvZMnQB0vaqI+Ic4MOr52qK1EUY9+eC5j/Z67mO9noyIxxM1AQehtKoqdQJ0a2unT/eoLgAKxuALLrhyT1NT6gzIKUY+JFGUhUs+EQeu+YRrPgDQEfPrm2s++/bKP0TEH1K3AMAh6BsRx0b7tZ6ar/zCpZ5u4LmP9XruI73qI2JlqigASOC81AEAkC39xo1bGB7jDH/HyIfurun9byi/bq5rPgDQEZmVzbuOO3JQTyMfAPLF6Ggf9lx2xYJVEUY93dnzHuk18aTBsyKiKSIeiIi2lGFAu8b3fjBGPPzL1BnQLTXdcstHUjcAQLYMOuecGXsaG1NnQM4x8iGJkmyd8omI40f0WTr3sSbXfACgA+bXN9fUnDbcNR8AclVpRLwu2sc9U67/pUdwFahMbX3zM/+7Lzn3DeU3RMRjEbEmYRMAdJUxrXV11akjACAb+o0duygiFqXugFxk5EMh2PL+N5ZfN/dR13wAoAMyK1t2H1c10DUfuq+jBvdKnQB0TN+IOD4iqj5f+3RNGPXwfJlnrvuc1X7d54mIeDxxExSs0oqK1AnQ7WyYOfPS1A0AkC39xo37Sdvq1akzICcZ+ZBEcfYO+URExIkj+iyZ+6hrPgDQEbX1zTWfzgz/S0TUp24BoGANjPZhz9ArFqwy7OFgZOa3X/d55lFeayLiwcRNAHC4KrcuXjwxdQQAZNG3UgdArjLyoVBsO++NQ74y59GNPiEMAAcvs2bT7ldXHtHTyAeAbCqLiJMiomr6Tw17OGTPPMpryYFv/0dEPJCwBwrK0686Kfpd9e+pM6A7mZY6AACyZfD558/YvcZTmOGlGPmQRFFRlk/5RMQJVX2Wznk0XPMBgA6orW+u+eQ/DX8qIpanbgGg2zs5Ikb/x09WGvbQmTIREbcsa7jmwLeNfSBLeo0enToBuo31119/UeoGAMiW8gsuuCp1A+QyIx8Kybbz3zTkK3c94poPAHRAZt3m3aOHDyg18qFbOXpIWeoEoN1xEfEPETHlpl9viDDuoetkIiJ+8EDDNQce42XEDEC++HTqAADIlgHV1XdHRFPqDshlRj4kUZz9Qz4REXFiVZ8ldz3img8AdERtfXPNRW8b5g/CAOgsVdH+OK6ps/57XYSPz8iuZx/jdVb72Oe3EfFk4ibolpou+FQMX/KfqTMg77XMmXNm6gYAyJbyCy64es/GjakzIKcZ+VBodk5685CrZz/smg8AdEBm/Za20UP7u+YDwCErjYg3R8Twr/xijcdxkQsy8w+Mfc59Q/kNEXF/RGxL3AQAL1TdWldXnToCALKh3ymnLIqI+tQdkOuMfEiiuCjRKZ+IOKmq7+LZD290zQcAOqC2vrnmE+OGrYyIR1K3AJBXjo2I111au3JK+BiM3JS5+7GmzN2PNS2ZPLbiiohYmjoIupMeFRWpEyCvNd5005TUDQCQLQPPPPPbbevXp86AnGfkQyFqu+AtQ66+8yHXfACgAzINW9tGVfQrNfIh771maFnqBOjuBkbEGyJi2jfu9zgu8kbm1rrGqw48wuuRiFiZOgiAgnds69Kl41NHAEAW1aYOgHxg5EMSxcVpf/3Xj+x7/50PueYDAB1RW99c8/G3DlsTEQ+mbgEgJx0TEcdP/+mqKeFjLfLTs4/wuuDNQ66OiEWpgyDfrX7dKfGqDU+kzoC81DBr1vTUDQCQLUP/7d8u2b1mTeoMyAtGPhSqvR98S8WXbn+ocVr45DMAHKzM936z4dqPnjr0tNQhAOSUUyNi+Nd/ta4mfHxF95C58+GNMfGkwf3DVR8A0hiweeHCSakjACBbBp199ozUDZAvjHwoZPdHxLTUEQCQh06NiAdSRwCQ1NCIeFNETL1lWUOEcQ/dT6b2wFWfD46p+FK0fw4BOATNs2enToB8dHnqAADIlkFnn31zROxN3QH5wsiHJH63ZnvqhCgqirhwTMX02x5svDJ8QhoADlbmBw80XPORU1zzIT+9dnjv1AmQ706KiFdf9V+rXe2hUGRuf7Bx2lmvHzwwIn4ZEVsS90De2fK5L8aQe36QOgPyyrqrr56augEAsqX8Ax/40t6WltQZkDeMfCh0S1IHAECecs0HoLCMi4irvrVkfYRxD4UnM39Fc2b+iuYl/3ba8M9ExOOpgwDo1ianDgCAbOl/2mm1EbEudQfkEyMfkigqSl3wNx8aWzH9R3Wu+QBAB2RuWdZwzeSxFaelDgGgSw2IiFMi4rJb6xojfMwEmW8uXn/jB97i8V3QUaWVlakTIG8033HHpNQNAJAt5ZMnf3HP5s2pMyCvGPmAaz4AcKjGRcTS1BEAdLrKiHjTtJ+uujgMe+CFMnc81Djt7JPLB0REbeoYALqdTGtdXXXqCADIhn6nnLIoIupTd0C+MfIhieJcOuUTER8+ZegVP1zWcFX4BDYAHKzMrXWNV33INR/yyD9W9kmdALludEScfPV/rakJHxvBy8nMW94UZ500uDja/+JQU+ogyHXr3jo+Rj35aOoMyHkNN954ceoGAMiWgWee+e0969enzoC8Y+QD7VwhAIBDkwlX8QDy3XERcdz1v1xr3AMHLzO/vjkzv755yZS3V34iIp5IHQRA3hu1dcmSCakjACCLalMHQD4y8iGJ4tw65BMRER89deh//OCBhmvCJ7UB4GBlflTXeOUHx7jmA5Cnjo+IY2f+9zrjHjh0mRn/ve67/9/bhl0SEY+kjoFc1qOiInUC5LQNN9xwZeoGAMiWof/2b5fsXrMmdQbkJSMf+JsHUgcAQJ46PSLuTx0BwEE7KSJe/c3F6417oHNkvvPrDddPHltxRbgUDMChKdm0YMHk1BEAkC2Dzj57RuoGyFdGPiRRlIOXfCIiPvbWoZ///m8arg2f6AaAg5W5/cHGaR98S8X9J1T1Sd0CwMs7OSJGf2uJcQ90gcytdY1XXfCWIVdHxKLUMZCL/u+IUTHolm+kzoBcNSV1AABky6Czz745Ivam7oB8ZeQDz/fgxJMGz6qtb/YJbwDoGNd8AHLXyREx+qb/Me6BLpa586GNcf6bhhRHxC9Sx0Au6llVlToBctLqSy+9PnUDAGRL+Qc+8KW9LS2pMyBvGfmQRHGunvKJiKH9S1dGxJLwyW8AOFiZ2x9qnHbdWUctCX8DAyCXnBwRo2/+9QbjHsiezF2PbIzz3jQkwtAHgIMzMXUAAGRL/9NOq42Idak7IJ8Z+cDfe8Q1HwDosEz96m2nn1jV1+MpyEk5vDGHrnBcRBzncg8kk5lj6AMvasMZ74+R9f+TOgNySuN3vvOp1A0AkC2DJ036altjY+oMyGtGPiRRnON/yDJ8QOlT4ZoPAHTInQ9vvPzEqr6LI6ItdQtAgTomIk6ctdi4B3JAZs4jG+OCNw/ZFxFG0AC8lJNaly2rTh0BANnQb+zYRRHxYOoOyHdGPvDilrvmAwAdlqlfs+20E0b08QdZ5JSSXF+Yw+GriogxX//VOuMeyC2ZOx/eGBeOqdgd7X+RCIiIHkOGpE6AnLFh5szLUzcAQLYM+Od/vqVtnSd1weEqTh1AYSoqKsr5l8ojej5zzQcAOEizH954eUSUpe4AKBADI2LCV36x5s75K5rnhYEP5KLMbQ82XhkRp6YOASDnlG9ZtOjc1BEAkEVzUgdAd+CSD7w013wAoOMyv12zPXP8iD6/SB0CzyhJHQCdryQi3vnFn626LAx7IB9kblnWcE3N2ys/GRF/SB0Dqf216nXR/zrHSyAirkgdAADZUvGJT0xvW7MmdQZ0C0Y+JJEvT0yoGtjzL9F+zccnzgHgIN31yMbLrn7vqKURsS11C0A3NG7q/KevCh+jQL7JzPrvdTdddkbVBRHhM9sUvJ5VVakTILn1118/JXUDAGTLoPe//7rUDdBdGPnAy6t3zQcAOizzuzXbxx0/ordrPiTXs4cnFNNtHB8Rx95a11gTBj6QrzJ/WL9jzNjR/RZERFvqGACS+nTqAADIloETJtwaETtTd0B3YeRDEvlyySci4shBPZ8I13wAoEPmPLrxsqtGHOmaD8Dhq4qIMTcuWW/cA91AbX3zvKKiOLtXj+J7+/cqiWEDSlMnQRLDR45MnQBJtcyZc2bqBgDIlvILL5y+t6UldQZ0G0Y+8MoeP+ukwbPmu+YDAB2R+e3a7ZnjK/ssTB0CkKcGRMS4r/xizdQw7oFuZf6K5prz3jRkW0S4eghQmKpb6+qqU0cAQDb0z2QWRMTK1B3QnRj5kERxUR6d8omIUYN7/SFc8wGADpn7aNPU4/+lz9KI2JK6BSDPnP6FBaumhY8/oLvKzHlkY3z8rcM2RcSDqWMghdLhw1MnQDINN944JXUDAGTLoHPPvaFtw4bUGdCtFKcOgDzxh7NOGjwrdQQA5JnM42u3j9u3P8KLlxQvZaU+3CHvnBQR77vjoUYDH+j+Mt/7zYZrI2Jo6hAAsuqY1qVLx6eOAIBs6Dd27KJoP6IAdCKXfEiiJA//vGX0kF6/Ddd8AKBD5j7WNPWL7+nzQERsSt0CkMPKI+Jt31qyfkr4eAMKSeZ/124f16tH8b3DBpSmboGsemj4yXHqnlWpMyDrGmbOvDx1AwBky4Dq6tv3uOIDnc7IBw7ek2edNHjW/Ppmn3QHgIOX+d9129923PDeC1KHAOSo6i8tXH15GPdAQZpf31xz3huHbIuIX6RuAaDLlW1asGBy6ggAyKLbUwdAd2TkQxJFRUWpEw7J0RVlrvkAQAfd/VjTxdPGj3wgIppStwDkkJMi4tV3PryxJnx8AYUsM+fRjfHZt1eujIg/pI6BbGqZOzd1AmTb1NQBAJAtFZ/4xPQ2V3ygSxj5QMc8edbrB8+av8I1HwDogMzv1+049bWu+ZBFA8pKUifAS+kbEad/a8n6i8O4B2iXebp513E9exT9oXJAz9QtkDWlVVWpEyCr1k6ffmXqBgDIlkHvf/91qRuguypOHUBhKs7jl2OGlC2P9ms+AMBBumd508URMTR1B0Bip16xYNXP7lne9J9h4AM8R219c01EjE/dAUCXOS91AABky8AJE26NiJ2pO6C7cskHOu4p13wAoMMyf1y/Y8yxw8pc8wEKUVVEjLllWYNHcwEvJTP30ab47NsrnwqP7aJAlFZWpk6ArGm65ZaPpG4AgGwpv/DC6XtbWlJnQLdl5EMSxcVFqRMOy7FDez8S7dd8fIIeAA7SPcubLv6Pd1c9EhHrUrcAZFH1V36x5vLwsQPwyjJPN+86rl+vkj8cO7QsdQsAnWdMa11ddeoIAMiG/pnMgohYmboDujMjHzg0K9/3+sEz7nXNBwA6IvOnDTvHHDu0rDZ1CN3boD4+zCEnjI6Ik+98aKPrPcBBq61vrvnAWyo2RcT9qVugq5VWVKROgKzYMHPmpakbACBbBp177g1tGzakzoBurTh1AIWpuCj/X/5hWO+Ho/2aDwBwkOYtb5oS7Y+tAejOqr+2aO0Pa+ub54WBD9AxmTseapwWEQNShwDQKSq3Ll48MXUEAGRDv7FjF4U/O4Uu56+4wqFbc/bJ5TPmLW/ySXsAOHiZP23Y8ebXDO29JnUIQBcYHREnz37Y9R7gsGR+u2Z75lXlvRakDoGuVDJoUOoE6HIN3/zmtNQNAJAt/d/xjtlt69alzoBuzyUfkigq6h4v/zCs7MGwSAWADrl3RfOUiBiVugOgk1Vf/0vXe4DOcc/ypoujfTgIQP4qaZk376LUEQCQRbemDoBC4JIPHJ5155xcfsM9rvkAQEdknmjY8aZjKspWpg6h+6noV5o6gcJTGRGn3Ol6D9C5Mn9p3Hly1cCeT6UOga7yPzE8Tpj/rdQZ0JWmpA4AgGwpv/DC63avWpU6AwqCkQ9JFBcVpU7oNK8d3vuZaz4+oQ8AB2n+iuaaf68esTwi/MEVkM8y1/zXmivDxwJAF5hf31zzmczwJyLi8dQt0FV6VlWlToAus/rSS69P3QAA2TJ40qSrUzdAoTDygcPX4JoPAHRY5snGnScfPaTMyAfIRwMi4p0/qmt0vQfoSpnVm3YfW3lETyMfgPwzMXUAAGTLEePHz46ILak7oFAY+ZBEcfc55BMREa+r7P1ALHfNBwA6Yv6K5pqL3znitxHxZOoWgA44+QsLVn0jvO8PZEFtfXPNJ/9p+FMRsTx1C3SF0iOPTJ0AXaLxxhs/lboBALJl8AUXXLmnqSl1BhQMIx/oHE3nvqH8hrsfc80HADog83+NO08cPaSXkQ+dYviAnqkT6P7OuPnXGy4LAx8gezLrNu8ePXxAqZEPQP44tnXZsurUEQCQDf3GjVsYEU+k7oBCYuRDEsVF3eyUT0T8Y2WfX98dTa75AEAHzK9vrvl/76h0zQfIdVURMWbOoxs9ngvIutr65pqL3jbMNR+6pR7l5akToNM1zJo1PXUDAGTLoHPOmbGnsTF1BhQUIx/oPJve/4by6+a65gMAHZF5auOuE48a7JoPkLPGfeUXa64K4x4gncz6LW2jh/Z3zQcgDwzYvHDhpNQRAJAN/caOXRQRi1J3QKEx8iGJ4u53yCciIo4f0Wfp3Mdc8wGAjphf31wz5e2Vj4ezrkDumfDDZQ0Xh/fvgcRq65trPjFu2MqIeCR1C3Sm5tmzUydAZ7s8dQAAZEu/ceN+0rZ6deoMKDhGPtC5tvzrG8uv+/GjrvkAQAdknm7edfyRg3sZ+XDIRg7smTqB7qUqIsbc/ViTx3MBuSLTsLVtVEW/UiMfupWeRx6ZOgE61bqrr56augEAsuhbqQOgEBn5kER3veQTEXHCiD5Lfvyoaz4A0BHz65trat5e+YeI+EPqFqDgjfnKL9ZcG96fB3JMbX1zzcffOmxNRDyYugWAFzU5dQAAZMvgSZNm7F67NnUGFCQjH+h8285705CvzHlkoz8UAICDl1nVvOu4qoE9jXyAlMZ//zcNU8PAB8hNmcbWtqoh/Xw6j+6jtLIydQJ0muY77piUugEAsqX8wgunp26AQlWcOoDCVFRU1K1fThjRZ2lELEn9zxkA8sn8+uaaiDg+dQdQkAZExPvmPtpk4APktNr295fGpO4A4O9kWuvqqlNHAEA2HDF+/OyI2JK6AwqVv/oDXWPb+W8a8pW7XPMBgI7IrN60+9iqgT0fTx1CfjlqcK/UCeS346b9dNVNYdwD5IfM93/TcO1HTx16WuoQ6Aylw4alToBO0XDjjRenbgCAbBl8wQVX7mlqSp0BBcslH5IoLur+LydW9VkSrvkAQIcc+NvpJ6XuAApGZtZ/rzPwAfLRqakDAHjWqK1LlkxIHQEA2dBv3LiFEfFE6g4oZC75QNfZecGbh1x958Ou+QBAB2TWbNr96soBpfWpQ4Bub/yP6ho9ngvIR5kfPNBwzUdOcc2H/FcyaFDqBDhsDTNnXpm6AQCyZdA558zY09iYOgMKmks+JFFSXFQQLyeN7Ht/uOYDAB1y4JrPyak7gG6rb0S8b+5jTQY+QL5zzQcgvbJNCxZMTh0BANnQb+zYRRGxKHUHFDqXfKBr7f3AWyq+dMdDjb9KHQIAeSSzbkvb6GEDSpenDiH3vXpIWeoE8svoR1ZuO7m2vnle6hCAw5S5ZVnDNR92zYc81zJ3buoEOFxTUwcAQLb0GzfuJ22rV6fOgIJn5EMSRUWpC7LnpJF9ltzxUCwJf0sYAA5abX1zzf/3tmErI+KR1C1At/Gmr/1y7fXh/XKgexkXEUtTR8Ch6jl6dOoEOCxrLrvMo7oAKCTfSh0AGPlANuz94FsqvnT7Q43Twh8oAMDBymzY0jaqol+pkQ/QGU7/zq83eH8c6G4yP1zWcNXksRWnpQ4BKFATUwcAQLYMPv/8GbvXrEmdAYSRD2TL/RExLXUEAOST2vrmmo+/ddiaiHgwdQuQ18bf/lDj1DDwAbov13zIWz0rK1MnwCFr/M53PpW6AQCypfyCC65K3QC0M/Ihid+t2Z46IauKiiIuHFMx/bYHG68Mf7gAAAcr09jaVjWkr3dZeXHHDuudOoHcN3HuY01TwvvgQPeVubWu8aoPueYDkG0ntS5bVp06AgCyYUB19d0R0ZS6A2jnT0wge5akDgCAfFNb31zzsVOHuuYDdNSAiHjnvSuaa8LABygMmfB5B/JQjyFDUifAIdkwc+blqRsAIFvKL7jg6j0bN6bOAA4w8iGJoqLUBWl8aGzF9B/VueYDAB2Q+f4DDdd+5JShp6UOAfLGqEdXbntTbX3zvNQhAFmS+VFd45UfHOOaD0CWlG9ZtOjc1BEAkA39TjllUUTUp+4A/sbIB7LL36oDgENzakQ8kDoCyHnHX3vfmhvDqB4oTKdHxP2pI6Ajmu68M3UCHIorUgcAQLYMPPPMb7etX586A3iOov3796duoADNX9GcOiGlU29Z1nBN+IMHAOiIJR92zYfnOG5479QJHKbWXXtj2+59sX33vmjbuy9279kfe/ftj737I/bt2x/7I+KZD1f37d8fRUVFURTtV0GLIiKKIkqKiqKkuCh6FEeUlhSP+d5vNlwb3s8GCteSD77FNR/yyz/99w9TJ0CHrb/+en+oAkDBGPnVrxbo81kOzpDJk1MnUIBc8oHsc4Xg/2fv7uOjrM+87x8zkEdCIJk8kAfCUhHFAgFFCTTuSUF8oCJgwFVQfKza7ZJyFUQRF4orWlGvC7CtumsRH0AKYmJpudrG5SJ3aQgSCIO0rIhlBUJIJjOBEELIEOb+A3e3aoIZSM5jZn6f977O1/Xv56a9Xz1hjvkOAAAXJ19EtmpHAAhJ+f/2p5pnhAMfAGDNBwC61g+1AwAAsEvarFlzW6qqtDMAfAVLPlBR7DZ6yUdEZPQvy1jzAQAgSKX35vHtdJz37Yx47QRcok5c8hn7zkeehcK7NQCIiJTefV3qmKFZ/O8kwkfalg+0E4AOq1+79g+N5eXjtTsAALDDFVu2dBeRVu2OUBZ35ZXaCTCQUzsAMBRrPgAAXBw+xAfwt27iwAcAvmasdgAARKjxHPgAAEyRVFDwqnDgA4Qklnyg4oM9xi/5iIiMfP1Ptc8LH0gAABCM0pkjWfMx3eBM1gkiQScs+UxYt9M7T3ifBoCvKl06pd844R/kESYy/8x34RAePK+88tvGrVsnaHcAAGCHAUVFmSJSrd0R6hJGjdJOgIFY8gH0bJ+cm7xCOwIAgDDEB/oAOPABgPZZ7iOnxgYC548leXhC/QHCxEAOfAAApug5ZkyxcOADhKzu2gEwk9Ph0E4ICWk9ow6JSKnw4QQAAB1lvbXds/ie61LHDM1mzcVUfBhkvInrdnnnCO/QANCu1TvqFgzN6rFFRPzaLcA36e5yaScA36h2xYpF2g0AANgl5b77ftJ64oR2BoB2sOQD6KpgzQcAgIsyVjsAgIqJ6znwAYCOsNxVp8YEhP/j/0L//4AwkHhi06bp2hEAANghYdSoEhFxa3cAaB9LPlDhZMjnv/VJjDoorPkAABAM6+2PPAtfyO5XKiKt2jEAbDP5vUrvbOG9GQA6ZM2OugVDs3K2CGs+CHG+NWu0E4BvskA7AAAAu/SeNOkX/mPHtDMAXABHPoC+ysm5ySuK3T4+rAAAoOOs3UdOjc3N6lGiHQLAFpM3cOADAMGy3Eeaxg7Jiv+9dghwITGXXaadAFzQ0UWL5mk3AABgo2LtAAAXxpEPVDgcTPn8rYxe0az5AAAQpNUf1S3IndJjs7DmA0S6ie/v9s0W3pUBIGjvVtTNH5KVUyoizdotABCm7tQOAADALmmzZs1tqarSzgDwDTjyAUIDaz4AAATP2n3k1NghmfGs+RikG7/7apqJ71V65wgHPgBwsaw9VU3WkEzWfBC6ojIytBOAdnlXrnxAuwEAALskFRQs024A8M2c2gEwk9PB89Unq3f0Z3J+zQcAAHTQmh11C0QkVrsDQJfgwAcAOsHairr5ItJDuwMAwtDIxvLy8doRAADYIamg4FVhMR0ICyz5AKHDzZoPAABBs/ZUNVmD+Xa6EaK6seJjkAnrd3HgAwCdxPq4qil/cGYc70sISVGpqdoJQJtqli9/QrsBAAC7uO6+++nW+nrtDAAdwJIPVHRzOnjaeHKSY/YJaz4AAATlXb6dDkSam9bt8s4TDnwAoNOs3cn7EgAEKePkli2TtSMAALBDzzFjikWkWrsDQMew5AOEln1TcpNXFLHmAwBAMKyPjzblD87g2+mRjyUfA4z/4mdleB8GgM5lfXy0yfp2Rvwm7RDgq7olJWknAF9T+/LLC7UbAACwS/L06T/1ezzaGQA6iCUfqHDytPv0S47ZK6z5AAAQlLWs+QCRwFq9o26BcOADAF3iVzu980QkUbsDAMJAt/oNGx7VjgAAwA4JeXklIrJduwNAx7HkA4Se/az5AAAQNL6dHuFio/h+QoQb+dZ2z2LhwAcAupK1t7opn/clhJr6DRu0E4Cvmq0dAACAXRJvuWWlv5pf6gLCCUc+UOHkM5oL6p8Ss0fOr/nwIQcAAB30q53eeU/fGr9VRBq0WwAEZfjrf6p9Xnj3BYAut26nd97iW+PLROS4dgvwX6KzsrQTgC858sQTL2o3AABgo7XaAQCCw5EPEJoOsOYDAEDQrL3VTflX9eHb6UAYGfDK/3fs/wgHPgBgF+vPR5tGD8qI430JANo2WTsAAAC7pD788CJ/VZV2BoAgceQDFQ6HQzsh5H0rNZY1HwAAgrRup3feT77Ht9OBMOF66cOjrwvvuwBgq3W7vPMWfS97u4h4tVsAEZGoPn20E4D/5nnttX/UbgAAwC5Jd9yxVLsBQPA48gFC14Epw5JXFO1mzQcAgCBYf6luGn1lH76dDoS4bnuqmizhwAcANFh/qT49elCfuI3aIQAQYnIbt20brx0BAIAdek+cuEpEmrU7AASPIx+ocDLk0yEDUmMrhTUfAACCsm6Xd97CCXw7PdKcPRfQTsAlqG86KydOt8qpM61y5mxAWgOBScVu3wbtLgAw1fpd3jkLJ2SXCe9LCAHdU1K0EwAREalZvnyBdgMAAHZxzZy5qLW+XjsDwEXgyAcIbQdZ8wEAIGjWvmOnR1+ZzrfTI0VctFM7AZ1rYtFuX6F2BAAYjjUfAPgyV0NJyTTtCAAA7NDTsjaKyCHtDgAXhyMfqHA6mPLpqIFpcRXCmg8AAEFZv8s7559vyd4uIrXaLQC+ZPx7ld45wrstAKh7r5L3JYQG369+pZ0AiIjM0w4AAMAuSdOmveSvqdHOAHCROPIBQt+h24clL3ufNR8AAIJh7Tt2euQV6bF8Ox0IHSNW76hbIBz4AECo4H0JISE6J0c7AZDqJUs48gEAGCEhL69Ezo8LAAhTHPlAhZMhn6BckR63Q1jzAQAgKO9VeucsuDmrQkSqtVsASP9/3VrzovA+CwAhhfclABARkfu0AwAAsEvijTe+fbaWMU8gnHHkA4SHqoLhrmUbKr18KAIAQMdZ/1HTPHJgWmyxdghguNhPa5uHCwc+ABCKrE9qmkcMZM0HiqIyMrQTYDjfO+9M124AAMBGb2sHALg0HPlAhYMln6BdkR67XVjzAQAgKBsqvbPn35S1Q0SqtFtw8U6cbtVOwEXwNvql8cw5OdN6bkKx27dBuwcA0Lb3Kr1znmTNB4C5rMby8vHaEQAA2CH14YcX+Y8d084AcIk48gHCR/XU4a6X3mPNBwCAYFif1Jy+9vK0OI58AB03Fe32FWpHAAAuyPqE9UMoikpP106AwWp/9rM52g0AANgl6Y47lmo3ALh0Tu0AmKmbw8FzEc+gPnH/teYDAAA66P3dvtkikqPdARho5NqddfOFJUoACHkbKr2zRSRLuwMAbJZzsrR0onYEAAB26D1x4ioRadbuAHDpWPIBwkstaz4AAATN+rT29NUDUmMPaYcgeA5+5zVc5bxeVvu8cOADAOGC9UOo6ZaUpJ0AQ9UuX75YuwEAALu4Zs5c1Fpfr50BoBNw5AMVfFZz8a7KiCuTSikVPjABAKDD3t/tmz1vfOYuEeHQJ8z4WwPaCQiC95RfGs+ck9ZzgRHC+yoAhJX3d/tmP35jFu9LAEwRe3zjxvu0IwAAsENPy9oovOcDEYMjHyD8eO+42rV03S7WfAAACIL1qad5xGUprPkANphc7PYVakcAAIJmfVp7+urL0+J4X4KtdsX1k/5vvqCdAfPM0w4AAMAuSdOmveSvqdHOANBJOPKBCidTPpfkqoz4MhEvaz4AAAShaLevcO4NmZUiclC7BYhg1oZK72zhPRUAwhJrPtASlZWlnQDDHF20iJ/qAgAYISEvr0RESrU7AHQejnyA8HT8jmtcS9ftZM0HAIAgWJ/VNQ/v74rlyAfoGgPeLPcsFg58ACCcWftrT48YwPohgMh2p3YAAAB26Tlu3Bp/dbV2BoBOxJEPVHRzaheEvyGZ8VvX7WTNBwCAYBTt9hX+eFzmHhE5oN2CjukV1007Ad/gcP0ZOXG6VfytgaHCuykAhL2i3b7Cx1g/hM2iMjK0E2AQ78qVD2g3AABgo1XaAQA6F0c+QPhq+IdrXEt/xZoPAADBsA7WNQ/t54rhyCcMJMXz15UwMrHY7SvUjgAAdArrQF3z8MtSWD8EEJFGNpaXj9eOAADADq6ZM5e2HD6snQGgk/Gv5lDh0A6IEEMy40t/xZoPAABBKXL7CmePzdgrIvu1W4AIMXL9Lu8c4Z0UACJG0W5f4VzWfGAjlnxgl5qXXnpCuwEAALskT5++RLsBQOfjyAcIb6fuHJHy3NqKOj5QAQCg46zPvWcG5yTHcOQDXLrer/+p9nnhwAcAIo31WV3z8P4u1nwARBTXyS1bJmtHAABgh14TJqwRkQbtDgCdjyMfqHA62fLpLEOz4kvXVghrPgAABKHI7Sv80Xcz9onIPu0WtM9/NqCdgAs4cvyMnGhuHSu8hwJARCra7Sv88bjMPSLCz5yiy/nWrNFOgBme0g4AAMAuyTNmLD7r9WpnAOgCHPkA4a/5rhEpz73Lmg8AAMGwDvnODMpOiubIB7h4+UW7fYXaEQCALmMdrGse2j8lhiMfdLnorCztBBjg2IsvztZuAADADgn5+ZtEhBVzIEJx5AMVDPl0rtzs+M3vsuYDAEBQity+wllj+uwXkb3aLUAYSltV7nlGeP8EgIhW5PYV/nhcBms+ACLBD7UDAACwS9LUqcvOejzaGQC6CEc+QGTwz7g2ZcnqHaz5AAAQBOtwfcvArN7RHPmEKKdTuwBt+U/vGTnZ3JovHPgAgAmsg3VnhvZLZs0HXSsqO1s7ARGufu3aSdoNAADYISEvr0RESrQ7AHQdjnygwulgyqez5Wb32Lx6Rx1rPgAABKHY7Sv8odXnMxFxa7cAYcQqcvMzXQBgiiK3r3D2dzP2CnP/AMLX+Mby8vHaEQAA2CEhP/8D/5Ej2hkAuhBHPkDkaL37utSn3/nIs1A49AEAoKOsquMtl2UkRnHkA3SM663tnsXC+yYAmMT63HdmcN/kGI580GW6p6ZqJyCCeV55ZbZ2AwAANvq5dgCArsWRDxBZNovIQu0IAADCSbHbV/iD69MPikildgu+LDaK3+sKJX/1NIu36awlHPgAgHGK3L7Cwu9m7BORfdotABCkgY1bt07QjgAAwA7J06cvazl6VDsDQBfjyAcqPq5q0k6ISA4Ruee61KffZs0HAIBgWNUN/v7piVEc+YSQfskx2gn4upFFu/mZLgAwlHXYd2ZQdlI0Rz7oEt1dLu0ERKjaFSsWaTcAAGAX18yZ/O8eYAC+GgtEns3aAQAAhJtit69QREZodwAhLPb1strnhUNyADBW0fn3pcHaHQAQhMQTmzZN144AAMAOvSZMWCMiDdodALoeSz5Q4XBoF0S2mSNTF7213bNY+BAGAICOsmoa/DlpPaMqtENwnvfUWe0E/I1DvjPjhXdLADCddbi+ZWBW7+i92iGIPL41a7QTEJkWaAcAAGCX5BkzFp/1erUzANiAIx8gMpVqBwAAEG6K3b7Ch/PTD4kIhz7Alw1Yv8s7RzsCAKCv2O0r/KHV5zMRcWu3ILJE9+2rnYAIVL1kyTztBgAA7JCQn79JRPZrdwCwB0c+UOFkyafL3ZeX+tSqcs8zwjeuAQDoKKv2pD8nJaE7Rz4hIDWBv6qEgk9qmuV409mhwjslAOA8q+p4y2VZvaM58gEQ6u7TDgAAwC5JU6cuO+vxaGcAsAn/cg5Erq3aAQAAhJtit6/woe+kVYnIdu0WIETkF7l9hdoRAIDQwZoPukJURoZ2AiKM7513pms3AABgh4S8vBIRKdHuAGAfjnygwulgyscOD4xKe3LlttpnhW9eAwDQUdbrf6p9/sHRaWO0Q4AQEPXGtlqWIQEAX2VVHW+5LCMxiiMfAKHKaiwvH68dAQCAHRLy8z/wHzminQHARhz5AJGtTDsAAIAwNVr431FVjc3ntBOMt99zerxw4AMAaEOx21f4g+vTD4pIpXYLIkN0VpZ2AiJIzfLls7UbAACw0c+1AwDYiyMfqGDIxz4Pjk578pdlrPkAABAE65dltc8+MIo1Hxgtbd1O7zztCABAyLKqG/z9+yRGceQDINRknNyyZbJ2BAAAdki+665lLVVV2hkAbMaRDxD5WCEAAODisOajqMnPko+mz31nRgtH4gCACyh2+wofZc0HnaRbUpJ2AiJE7csvL9RuAADALq4ZM57RbgBgP458oMLJlI+tvv+d9Mf/7U81zwsf1AAA0FHWym21z96XlzpGOwRQMGBDpXe2dgQAIORZxxr8/dN6suYDIGR0q9+w4VHtCAAA7JA4fvx6EfFqdwCwH0c+gBm2T85NXlHs9nHkAwBAcPJFZKt2hIlOs+Sj5tiJlqHCcTgAoAOK3b7Ch/PTD4lIhXYLwlv9hg3aCYgMs7UDAACwi2vGjCVn6+q0MwAo4MgHKhjysV9az6hDIlIqfGADAEBHWavKPc/MHMmaD4wyvMjtK9SOAACEDav2pD8nNSGKIx9ckuisLO0ERIAjTzzxonYDAAB2SBg1qkRE3NodAHRw5AOYo4I1HwAALool5w9lYadAQLvASNUN/v7CUTgAIAjFbl/h97+TXiUi27VbABhtsnYAAAB26T1p0i/8x45pZwBQwpEPVDhZ8lHRJzHqoLDmAwBAMKy3tnsW33Mdaz4wwvBiVnwAAMGzPI3+rJQE/pkRFy+qTx/tBIQ5z2uv/aN2AwAANirWDgCgh799A2apZM0HAICLMlZENmtHmIQdH/sdY8UHAHCRit2+woe+k8aaDwAtuY3bto3XjgAAwA5ps2bNbamq0s4AoIgjH6hwOpjy0ZLZK/ozYc0HAIBgWG9/5Fl493Wpm4dmxWu3GOOvdc3aCaZhxQcAcCms1/9U+/yDo9PGaIcgPHVPSdFOQBirWb58gXYDAAB2SSooWKbdAEAXRz6Aedys+QAAcFFY87FRN37f1VZVx1tY8QEAdIbRIlKmHQHAKK6GkpJp2hEAANghqaDgVRFp1e4AoIsjH6jgMxtd2b2j9wtrPgAABMN65yPPwqVT+pUKf5FG5MllxQcA0AmsX5bVPvvAKNZ8ELw/dP+WXPPmv2hnIDw9pR0AAIBdXHff/XRrfb12BgBlHPkAZto7JTd5RRFrPgAABMNyHzk1dkhWfIl2iAnio5zaCcY44Gm+TDj+BgB0HtZ8cFGis7K0ExCGjr344mztBgAA7NBzzJhiEanW7gCgjyMfqHAy5aOub3LMPmHNBwCAoKzeUbfgp1k5W0TEr90CdJL+Raz4AAA6j7VyW+2z97PmA8AeP9QOAADALin33feT1hMntDMAhACOfABz7WPNBwCAoFnuI01jh2TF/147JNLFsuRji73VTcOFo28AQOfLF5Gt2hEIL9F/93faCQgzvnfemaTdAACAHRJGjSoREbd2B4DQwJEPVPCRTWjolxyzV1jzAQAgKO9W1M0fkpVTKiLN2i3AJUor2s2KDwCg01lvbKt95t681DHaIQAimtVYXj5eOwIAADv0njTpF/5jx7QzAIQIjnwAs+1nzQcAgKBZe6qarCGZrPl0pZ6x3bQTIl7F540jhGNvAEDXseT8F4uADolKT9dOQBip/dnP5mg3AABgo2LtAAChgyMfqHAy5RMy+qfE7BHWfAAACMrairr5Q27L2Soip7RbgIvUbd0u7zztCABAxLLeLPcsZs0HQBfJOVlaOlE7AgAAO6TNmjW3papKOwNACOHIB8AB1nwAAAia9XFVU/63M+NY8+kiZ84G5DMPv4jWhUYJR94AgK7Hmg86rFtSknYCwkTt8uWLtRsAALBLUkHBMu0GAKGFIx+ocDoc2gn4G5elxlYKaz4AAARl7c66+f+S2XebiDRot0QqV0KUdkLEeunDo89oNwAAIp71Zrln8T0jWfMB0Klij2/ceJ92BAAAdkgqKHhVRFq1OwCEFo58AIiIHJwyLHlF0W7WfAAACIL18dGm/G9nxG/SDgGCNEA7AABglLEislk7AqGvft067QSEB35yFgBgDNfddz/dWl+vnQEgxHDkAxUM+YSeAaz5AAAQtHU7vfMW3xpfJiLHtVsiUXpPlny6wvb/bBwsvPMBAOxhvb3ds/Ce61I3D82O125BiIvKytJOQBg4umgRP9UFADBCzzFjikWkWrsDQOjhyAfAfzl4+7DkZe+z5gMAQDCsPx9tGj0oI441H4SLbhsqvbO1IwAAxmHNB0BnuFM7AAAAuyRPn/5Tv8ejnQEgBHHkAxVOpnxC0uVpcbuENR8AAIKybpd33qLvZW8XEa92S6Q54GnWTohEw4V3PQCAvay3P/IsfCG7X6mItGrHIHRFZWRoJyDEeVeufEC7AQAAOyTk5ZWIyHbtDgChiSMfAH/rEGs+AAAEzfpL9enRg/rEbdQOiTRZvaO1EyLO7sOncrQbAABGstxHmqyhWfGs+QC4WCMby8vHa0cAAGCHxFtuWemv5pe6ALSNIx+ocDLkE7KuSI/bIaz5AAAQlPW7vHMWTsguE9Z8ENp6F7l9hdoRAAAzvfORZ+HSKaz5oH1RqanaCQhhNcuXP6HdAACAjdZqBwAIXRz5APiqqoLhrmUbKr0c+QAA0HHWX6pPj74ynTWfznTQy891dbKrhUNuAIAey33k1NihWT1KtEMAhJ2Mk1u2TNaOAADADqkPP7zIX1WlnQEghHHkAxUs+YS2K9NjtwtrPgAABOW9Su+cp27O3i4itdotkeJbKTHaCRFl8W+PLNRuAACYbfWOugVDs3psERG/dgtCT7ekJO0EhKjal1/mPRYAYIykO+5Yqt0AILRx5AOgLdVTh7teeo81HwAAgmH9R83pkZenxbLm00m6CZfhncilHQAAgIhY7qpTY4ZkxrPmA6CjutVv2PCodgQAAHboPXHiKhFh2hrABXHkAxVOBx/YhLpBfeJY8wEAIEjvVXrnzL8pa5eIsKnbCf7Te0Y7IZIMFt7rAAAhYM2OugXPTcr5o/DhBb6ifsMG7QSEptnaAQAA2MU1c+ai1vp67QwAIY4jHwDtqZ12teul9btY8wEAIAjW/trmay9PjeXIpxMMSI3VTogYOw+dYskHABAqrD1VTdaQrPjfa4cgtMRcdpl2AkJQ/dq1N2k3AABgh56WtVFEDml3AAh9HPlAhdOpXYCOuCojrkxY8wEAICgbKr2zn7gxa4ew5oPQkVjs9hVqRwAA8F/eraibPyQrp1RY8wFwYeMby8vHa0cAAGCHpGnTXvLX1GhnAAgDHPkAuBDvHVe7lq5jzQcAgGBY+2tPX3t5WhxHPpeo8cw58Z06q50RCQYJR9sAgNByfs0nkzUf/I/uqanaCQgxnldema3dAACAHRLy8krk/JfuAeAbceQDFQ5xaCegg67KiC8T8bLmAwBAEN7f7Zv9+I1Zu4SJ3UtW1+jXTogEWdoBAAB81dqKuvlDbsvZKiKntFsAhKSBjVu3TtCOAADADok33bTqrMejnQEgTHDkA+CbHL/jGtfSdTtZ8wEAIAjW/trTIwakxHLkc4kGpsdpJ4S95/9QxU91AQBCkfVxVVP+4Mw41nwgIiLdXS7tBISQ2hUrFmk3AABgozXaAQDCB0c+UNHNqV2AYAzJjN+6bidrPgAABKNot6/wsRsyK0XkoHYLjJajHQAAQHvW7qyb/0xmX9Z8AHxV4olNm6ZrRwAAYIfUhx9e5K+u1s4AEEY48gHQEQ13XpPy3NqddRz5AADQcdaBuubh30qJ5cjnElQfb9FOCHcDhENtAEDosvYcbbIGZ8Rv0g6Bvv2uyyXl5cXaGQgNC7QDAACwS9IddyzVbgAQXjjygQqnw6GdgCANyYrfunansOYDAEAQinb7CufckLlHRA5ot4SrxjOt2gnhrrd2AAAAF7Jup3fe4Fvjt4pIg3YL9EX37audgBBQvWTJPO0GAADs0HvixFUi0qzdASC8cOQDoKNO3Tki5bm1Faz5AAAQBOuvnuah/VNiOPK5SFekx2knhLXn/1BVqN0AAMA3sPZWN+Vf1Yc1HwAiInKfdgAAAHZxzZy5qLW+XjsDQJjhyAcqGPIJT0Oz4kvXVrDmAwBAMIrcvsIfj8tgzQcacrQDAADoiHU7vfN+8r34MhE5rt0CXVEZGdoJUOZ7553p2g0AANihp2VtFJFD2h0Awg9HPgCC0XzXiJTn3mXNBwCAYFgH684MzUlmzeditJ47J8dPn9XOCFf9heNsAEB4sP5S3TR6UEYcaz6A2azG8vLx2hEAANghadq0l/w1NdoZAMIQRz5Q0Y0pn7A1LLvH5ncr6ljzAQAgCEVuX+GPvpuxT0T2abeEo4bTrdoJ4cqlHQAAQEet2+Wdt+h72dtFxKvdAj1R6enaCVBU+7OfzdFuAADADgl5eSUiUqrdASA8ceQDIFj+GdemLFm9gzUfAACCYB3ynRnUNymaI5+LMKxvD+2EsLToN4cLtRsAAAiC9Zfq06MH9YnbqB0CQEXOydLSidoRAADYoee4cWv81dXaGQDCFEc+UMGQT3jLze6xefUO1nwAAAhGkdtXWDimD2s+sEtv7QAAAIK1fpd3zsIJ2WXCmo+xuicnaydASc2yZYu1GwAAsNEq7QAA4YsjHwAXo/Xu61Kffucjz0Lh0AcAgI6yDtW3DMrqzZpPsOpPndVOCEdpwnsaACD8sOYDmCnq+MaN92lHAABgB9fMmUtbDh/WzgAQxjjyAXCxNovIQu0IAADCSbHbV/hDq89nIuLWbgknviaOfC5ChnYAAAAX471K75x/viV7u4jUarfAfvXFxdoJ0MHPzAIAjJE8ffoS7QYA4Y0jH6j4+GiTdgIukcMhcs/I1Kff3s6aDwAAQbCqjrdcltErmiOfIPSI6SbHTrRoZ4Qbl3YAAAAXydp37PTIK9JjWfMxUHRWlnYCFBx54okXtRsAALBDrwkT1ohIg3YHgPDGkQ+AS8GaDwAAQSp2+wp/8Pd9DopIpXZLOCly+7QTwg3fhgYAhK33Kr1zFtycVSEi1dotALrcZO0AAADskjxjxuKzXq92BoAwx5EPVDgd2gXoLPfmpS56s9yzWFjzAQCgo6zqEy39+yRGceQThEXfy9ZOCCuLf3tEOwEAgEthfVLTPGIgaz7GierTRzsBNvO89to/ajcAAGCHhPz8TSKyX7sDQPjjyAfApSrVDgAAINwUu32Fj16fzpoPugo/1QUACHvvVXrnPMmaDxDpchu3bRuvHQEAgB2Spk5ddtbj0c4AEAE48oEKhnwiy315qU+tKvc8I6z5AADQUdaxBn//tJ6s+XTUyeZz2gnhJEl4LwMAhD/rk5rmkQPTYou1Q2Cf7ikp2gmwUc3y5Qu0GwAAsENCXl6JiJRodwCIDBz5AOgMW7UDAAAIN8VuX+HD+emHRKRCuyUcNJ5p1U4IJ721AwAA6AwbKr2z59+UtUNEqrRbAHQ6V0NJyTTtCAAA7JCQn/+B/wg/rQ6gc3DkAxVOB1s+keaBUWlPrtxW+6zwrXEAADrKqj3pz0lNiOLIp4M49Okwfq4LABAprE9qTl97eVocRz6G8K5erZ0A+zylHQAAgI1+rh0AIHJw5AOgs5RpBwAAEG6K3b7C738nvUpEtmu3hIPTfn6yq4N6aAcAANBZ3t/tm/34jVm7ROSQdgu6XnRWlnYCbHLsxRdnazcAAGCH5BkzXmqprtbOABBBOPKBCidDPhHpodFpj79eVvu8sOYDAEBHWf/2p5rnHxydNkY7JBwUu33aCeGiUDsAAIBOZH1ae/rqy9PiOPIBIscPtQMAALCL6557ntZuABBZOPIB0Jm2T85NXlHs9nHkAwBAcEYLq3gAAABtYs3HHFHZ2doJsEH92rWTtBsAALBDrwkT1ohIg3YHgMjCkQ9UOBxM+USq1ISoKhEpFdZ8AADoKOuXZbXPPjCKNZ9v8sCoNFm5rVY7AwAA2M/aX3t6xICUWI58gPA3vrG8fLx2BAAAdkieMWPxWa9XOwNAhOHIB0BnY80HAICLw5pPBzw7KUc7IeQ9+QGffwIAIk/Rbl/hYzdkVorIQe0WdJ3uqanaCehinldema3dAACAHRLy8zeJyH7tDgCRhyMfqGDIJ7Kl9Yw6JKz5AAAQDGvlttpn78tLHaMdgrAXqx0AAEAXsQ7UNQ//VkosRz5A+BrYuHXrBO0IAADskDR16rKzHo92BoAIxJEPgK5QwZoPAAAXJV9EtmpHhLJm/znthFDXQzi0BgBEqKLdvsI5N2TuEZED2i3oGlHp6doJ6EI1//t/L9JuAADADgl5eSUiUqLdASAyceQDFd1Y8ol4GYlRB4U1HwAAgmGtKvc8cy9rPhfkbw1oJ4Q6lnwAAJHM+quneWj/lFiOfIDwE3ti06bp2hEAANghIT//A/+RI9oZACIURz4Aukolaz4AAFwUS84fyqINZ89x5PMNorUDAADoSkVuX+GPx7HmE6nq163TTkDXmacdAACAjX6uHQAgcnHkAxVOJ1M+JsjqHf2ZsOYDAEAwrDfLPYvvGcmaT3uONfglrWeUdkYo66YdAABAF7MO1jUP7eeK4cgnAkVlZWknoIscXbRosXYDAAB2SL7rrmUtVVXaGQAiGEc+ALqSmzUfAAAuylgR2awdEarO8pNdF8IFFAAg4hW5fYWzx2bsFZH92i0AOuRO7QAAAOzimjHjGe0GAJGNIx+oYMfHHNm9o/cLaz4AAATDenu7Z+E916VuHpIVr90Skg7Xn9FOCGUs+QAATGB97j0zuF9yDEc+ESYqI0M7AV3Au3LlA9oNAADYIXH8+PUi4tXuABDZOPIB0NX2TslNXlHEmg8AAMFizacdfZNiOPQBAMBwRW5f4ezvsuYDhIGRjeXl47UjAACwg2vGjCVn6+q0MwBEOI58oMLpZMvHJH2TY/YJaz4AAATDevsjz8KlU/qVikirdgwAAEAIsj73nRnclzWfiBKVmqqdgE5Ws3z5E9oNAADYIWHUqBIRcWt3AIh8HPkAsMM+1nwAAAia5T5yauzQrB4l2iGhqBtH4+1p0Q4AAMAuRW5fYeF3M/aJyD7tFgBtyji5Zctk7QgAAOzQe9KkX/iPHdPOAGAAjnyggs9kzNPPFbNXWPMBACAoq3fULRia1WOLiPi1W0INRz7tOqcdAACAjazDvjODspOiOfKJEN2SkrQT0IlqX355oXYDAAA2KtYOAGAGjnwA2GU/az4AAATNcledGjMkM541n69I6dFd6pvOameEIpZ8AABGKXL7CmeN6bNfRPZqtwD4km71GzY8qh0BAIAd0mbNmttSVaWdAcAQHPlAhdPBN69N1D8ldo+w5gMAQFDW7Khb8NyknD+KSLN2S6hhzadNrdoBAADYzDpc3zIwq3c0Rz4RoDTQR4YW/Vw7A51jtnYAAAB2SSooWKbdAMAcHPkAsNOBKcOSVxTtZs0HAIAgWHuqmqzBmfG/1w4JNTHdndoJoeiUdgAAAHYrdvsKf2j1+UxE3NotuHTRWVnaCegER5544kXtBgAA7JBUUPCq8KUrADbiyAcq+NK1uS5Lia0U1nwAAAjKuxV185fclrNVOOD4ktgoXirbcEp41wIAmMeqOt5yWUavaI58gNAwWTsAAAC7uO6+++nW+nrtDAAG4cgHgN0OsuYDAEDQrI+rmvIHZ8ax5vM3zraKdO/Goc9X+LUDAADQUOz2Ff7g7/scFJFK7RZcmqiMDO0EXCLPq6/+o3YDAAB26DlmTLGIVGt3ADALRz5QwZKP2S5Pja0QvmEOAEBQ1u6sm/9MZl/WfL7iieJD2gkAACA0WNUnWvpnJEZx5APoGty4bdt47QgAAOyQct99P2k9cUI7A4BhOPIBoOHQ7cOSl73Pmg8AAMGw9hxtsgZnxG/SDgklT9/aVxb+5rB2BgAACAHFbl/hD65PZ80nzHVPT9dOwCWoXbFivnYDAAB2SBg1qkRE+LlYALbjyAcqnA6mfEw3MC1uh7DmAwBAUNbt9M4bfGv8VhFp0G4BAAAIQVZ1g79/Oms+gJbEE5s2TdeOAADADr0nTfqF/9gx7QwABuLIB4CWqoLhrmUbKr0c+QAA0HHW3qNN+Vex5vMlBcNd2gmhhncsAICxit2+wkeuTz8kIhXaLbg4vjVrtBNw8RZoBwAAYKNi7QAAZuLIByoY8oGIyMC0WNZ8AAAI0rpd3nk/+V58mYgc124JFT1jnNoJoaZOOwAAAEVWTYM/J61nFEc+YSq6b1/tBFyk6iVL5mk3AABgh7RZs+a2VFVpZwAwFEc+ADRVTR3ueuk9vmkOAEAwrD9XN10/qE/cRu2QUJGTHCP1TWe1M0LJce0AAAA0Fbt9hQ/ns+YD2Ow+7QAAAOySVFCwTLsBgLk48oGKbkz54AtXpsdtF9Z8AAAIyvpd3jkLJ2SXiYhXuyVU9Iztpp0QSvjvBQDAdFbtSX9OagJrPuEoKiNDOwEXwffOO9O1GwAAsENSQcGrItKq3QHAXBz5ANBWy5oPAABBs/5SfXr0laz5/LdEjnz+Vp1wRA0AMFyx21f4/e+kV4nIdu0WwABWY3n5eO0IAADs4Lr77qdb6+u1MwAYjCMfqHA6tQsQSq7KiCuTSj6IAgAgGO9Veuc8dUv2dhGp1W4JBY1nzklCDC+ZX/BrBwAAEAIsT6M/K6UH//wZbqLS07UTEKTan/1sjnYDAAB26DlmTLGIVGt3ADAbf8sFEAq80652vbR+F2s+AAAEwfqPY6dHDkyPZc3nC+UHG7UTQsbk3OQVxW4f71YAAKMVu32FD41OY80H6Fo5J0tLJ2pHAABgh+Tp03/q93i0MwAYjiMfqHA4tAsQaq7KiCsTflYCAICgvFfpnfPkzVkVwjeIRESkRzRLPn/jpHYAAAAhwHq9rPb5B0enjdEOQcd1S0rSTkAQapcvX6zdAACAHRLy8kqE43EAIYAjHwChwnvH1a6l61jzAQAgGNYnNc0jB6bFFmuHhIKc5Bg51XJOOyNUHNEOAAAghIwWkTLtCCACxR7fuPE+7QgAAOyQeMstK/3VfM8OgD6OfKDCyZQP2vDtzPgy2eVlzQcAgCBsqPTOnn9T1g4RqdJuCQWuHvwV5wvVwkoiAAAiItYvy2qffWAUaz7hon7dOu0EdNw87QAAAGy0VjsAAEQ48gEQWo7fcY1r6bqdrPkAABAE65Oa09denhbHkY+INLWck3h+tktE5Lh2AAAAIYY1nzARlZWlnYAOOrpoET/VBQAwQurDDy/yV/FPbwBCgyMQCGg3wEC7j5zSTkDoSvznjYd/LXzrHACAYJQ+fmPWTBE5pB0SCvbXnNZOCBW3F7l9G7QjAAAIEaX3s+YTFvK3r9dOQMfceXTRone1IwAAsMPADz+ME5Fm7Q6EnvjBg7UTYCCWfACEmoY7r0l5bu3OOo58AADoOGt/7ekRA1JjOfIRkcS4btoJocKrHQAAQIjJF5Gt2hG4sJh+/bQT0AGeV199QLsBAAA79J44cZVw4AMghHDkAxVOh0M7ASFsSFb81rU7pVRY8wEAoMOKdvsKHxufWSkiB7VbtGUkRmsnhIoDIrxTAQDwBeuNbbXP3JuXOkY7BIgAuY3l5eO1IwAAsINr5sxFrfX12hkA8N848gEQik7dOSLlubUVrPkAABAE64Cnefi3UmKNP/I5FwhIlJOjchHhx+IBAPg6S84fwSJEdU9J0U7AN6hZvnyBdgMAAHboaVkbRYTlbAAhxREIBLQbYKC9R5u0ExD6Yud/cOh3wjfPAQAIRumcGzIfkvMLLkb7q4cV5S/cXuT2bdCOAAAghJTOHMmaTyibcM74m/VQ5/r01lvrtCMAALBDzs9+NkY4EMcFJE+dqp0AA7HkAyBUNU+/NmXJmh2s+QAAEATrr57mof1TYow/8umfEiMnm89pZ4QC1nwAAPg61nxCmHf1au0EXNhT2gEAANghIS+vRHhnBBCCOPKBCqeDn0/AN8vN6rFlzY66UmHNBwCADity+wp/PC5jj7DmIznJ0doJoWCfnP8HKd6nAAA4z3pru2fxPaz5hKzorCztBFzAsRdfnK3dAACAHRJvumnVWY9HOwMAvsapHQAAF+CfcW3KEu0IAADCjHWw7szQc+dETH+8jWe1/7MIBQ3aAQAAhKix2gFAGPqhdgAAADZaox0AAG1xBAIB7QYYaN+x09oJCB/d5hV9/u/Ct88BAAhG6ezvZjwsIvu1Q7R5T3HoIyJj3/7I8+/aEQAAhJjSe65LHTM0O167A21I/X8faCegDfVr1/6hsbx8vHYHAABdLfXhhxeJyNPaHQh9WU/zXxPYj5/rAhDqWu+5LvXptz/yLBQOfQAA6Cjrc9+ZwX2TY4w/8umXHKOdEAr2Cj/ZBQBAW8aKyGbtCCBMjOfABwBgiqQ77liq3QAA7eHIB0A42CwiC7UjAAAIJ0VuX2HhdzP2icg+7RZNDWdaJTGmm3aGtlrtAAAAQpD19keehS9k9ysVkVbtGHxZ99RU7QR8heeVV2ZrNwAAYIfeEyeuEpFm7Q4AaA8/1wUV63Z5tRMQfsa+vZ01HwAAgjElN7kgq3f0+9od2k4087mdnH+X4ie7AAD4iruvSx03NCueNZ8Qk/nnMu0EfNnAgzNmfKIdAQCAHS5bv76fiBzS7kB46Hn99doJMBBLPgDCBWs+AAAEqcjtK/wnq89+Of9zTca6LCVWOyEU7BJ+sgsAgK955yPPwqVTWPMJNd1dLu0E/I3aFSsWaTcAAGCHnpa1UTjwARDiOPKBCqdDuwDh6N681EVvlnsWCx9OAQDQUdaR4y0Ds3pHG33k42n0S2pClHaGtuNTcpNXFLl9vEcBAPBllvvIqbFDs3qUaIcAISrxxKZN07UjAACwQ9K0aS/5a2q0MwDggjjyARBOSrUDAAAIN8VuX+EPrT6fiYhbu0XTsYYW7QR16YlRB4U1HwAAvmb1jroFQ7N6bBERv3YLzvOtWaOdgP+xQDsAAAA7JOTllQifQwEIAxz5QIXTwZQPLs79o9KeemNb7TPCh1MAAHSUVXW85bKMxCijj3wcIhLQjtBXqR0AAECIstxVp8YMyYxnzSdExPzd32kn4AtHn356nnYDAAB26Dlu3Bp/dbV2BgB8I458AISbrdoBAACEm2K3r/AH16cfFMOPPI43tWonqLvzmpTn1u6s41gaAICvWLOjbsFzk3L+KCLN2i1ACLlHOwAAABut0g4AgI7gyAcq2PHBpXhgVNqTK7fVPius+QAA0FFWdYO/f3pilNFHPr3iu0laQpR2hrZK4Se7AABoi7WnqskanBn/e+0QiERlZ2snQES8K1dy5AMAMIJr5sylLYcPa2cAQIdw5AMgHJVpBwAAEG6K3b7CR65PPyQiFdotUFU7JTd5RZHbx5EPAABf8W5F3fwlt+VsFZFT2i1ACBjZWF4+XjsCAAA7JE+fvkS7AQA6iiMfqHAy5YNL9NDotMdfL6t9XvgWOgAAHWXVNPhzUhOijD7yOdbgl4QYp3aGqr9zxewV1nwAAGiL9fHRpvwhrPmoi0pN1U4wXs3y5U9oNwAAYIdeEyasEZEG7Q4A6ChHIBDQboCBPnD7tBMQAepOnb292O3boN0BAEAYKf3+d9IfF5Ht2iGaTD/yERE56D3DexQAAG0rXXJbzveENR9V3zrk1k4wXcaBKVOOakcAAGCH/qtXXyEi+7U7EJ56jRunnQADseQDFQ4HUz64dKkJUVXCt9ABAAiG5Wn0Z6X0MPuvASebWyWqm9nvoxmJUQeF9ygAANpifVzVlP/tzDjWfBR1S0rSTjBa7csvL9RuAADADgn5+ZuEAx8AYYYlH6j49Z567QRECE+jn2+hAwAQnNKHRqcZv+Zj+pGPiEh1A+9RAAC0o/RfJva9TfjZBjVXNB7WTjBZt0/GjDmrHQEAgB36Llt2o4iUaHcgfLnuvFM7AQYy+yu8UOPkFxLQSdITow4J30IHACAY1utltc8/MCptjHaIpjNnAxITZfZLaUavaNZ8AABom/Xx0ab8wRnxm7RDTFW/gTtkRbO1AwAAsENCXl6JcOADIAxx5AMg3FVMzk1eUez28eEUAADBGS0iZdoRUFXJexQAAG1bt9M7b/Ct8VuFNR8V0VlZ2gnGOvLEEy9qNwAAYIeE/PwP/EeOaGcAQNA48oEKs78zjc6WkRjFt9ABAAiOtXJb7bP3G77m0+w/J/HRZr+ZZvWO/kx4jwIAoC3W3qNN+Vex5gOzTNYOAADARj/XDgCAi8GRD4BIwLfQAQC4OPkislU7AqrcvEcBANC2dbu8837yvfgyETmu3WKaqD59tBOM5HnttX/UbgAAwA6ue+5Z6q+p0c4AgIvCkQ9UOJ0O7QREGL6FDgBA0Kw3ttU+c29e6hjtEE2NZ1olIaabdoYq3qMAAGiX9ZfqptGDMuJY84EJchu3bRuvHQEAgB2SZ8xYot0AABeLIx8AkYJvoQMAcHEsOX/gAXPxHgUAQDvW7fLOW/S97O0i4tVuMUn3lBTtBOPULF++QLsBAAA79JowYY2INGh3AMDF4sgHKhjyQVfomxS9X/gWOgAAwbDeLPcsnjnS7DWfk82tkhhr9ppPdm/eowAAaIf1l+rTowf1iduoHQJ0IVdDSck07QgAAOyQPGPG4rNe7rcBhC+OfABEkr1TcpNXFPEtdAAAgsWaD/ay5gMAQNvW7/LOWTghu0xY87GNd/Vq7QTTPKUdAACAHRLy8zeJyH7tDgC4FBz5QIXTwZQPukZOcsw+4VvoAAAEw3pru2fxPdeljhmaHa/douqQ74x2gipWEQEAaJf1l+rTo69kzcc2Md/6lnaCUaqXLJmt3QAAgB2Spk5ddtbj0c4AgEvi1A4AgE62b0pu8grtCAAAwtBY7QBtOckx2gna9k7mPQoAgDa9V+mdIyJp2h1AF7hPOwAAADsk5OWViEiJdgcAXCqWfKCCIR90pX6umL3Ct9ABAAiG9fZHnoUvZPcrFZFW7RjoYc0HAIB2Wf9x7PTIK9JjWfOxQVRGhnaCMXzvvDNduwEAADsk5Od/4D9yRDsDAC4ZSz4AItF+1nwAAAiatfvIqbGBgIjJT98k1nx4jwIAoG1frPlwfYJIYjWWl4/XjgAAwCY/1w4AgM7Akg9UOJnyQRfrnxK7R/gWOgAAQVn9Ud2C3Ck9Novhaz4Ow99V+ybH7BPeowAAaIv1SU3ziMvTWPPpalHp6doJRqj92c/maDcAAGCH5LvuWtZSVaWdAQCdwhEIBLQbYKD/t79BOwEGOOhtvr1ot2+DdgcAAOFk+rUpNw7JjDf+98mrG/zaCaoO+87cXuTmPQoAgDaUzr8pa4aI8ClRFxpStVs7wQQ5n02b9rl2BAAAdrj8N79JERGvdgciT48RI7QTYCCWfKDCafaXo2GTy1JiK4VvoQMAEJQ1O+oWPDcp548i0qzdosn019Uc1nwAAGiPtb+2+dqBabEc+XShbklJ2gkRr3b58sXaDQAA2CFx/Pj1woEPgAjCkg9UlH7Kkg/s8Vkdaz4AAATrrhEpNw/OjP+9doe22pNmr/kcYs0HAID2sObTxYY1MTDTxWL333DDae0IAADs0H/VqmEi4tbuQGTqdfPN2gkwEEs+UNGNKR/YZGBaXIXwLXQAAILybkXd/CW35WwVkVPaLZpMf2PtlxyzV3iPAgCgLdYnNaevvTwtjiOfLrIrrp/0f/MF7YxINk87AAAAOySMGlUiHPgAiDAc+QCIdIduH5a87P3dPj6cAgCg46yPjzblD86IM3rNJyWhu9Q1ntXO0LR/Sm7yiiI371EAAHzV+7t9sx+/MWuXiBzSbolUUVlZ2gkR6+iiRfxUFwDACL0nTfqF/9gx7QwA6FRO7QCYycHDY+MzMC1uh5z/FjoAAOigtRV180Wkh3aHOu0XGeWnn+u/13wAAMCXWZ/Wnr46EAgIT9c86DJ3agcAAGCjYu0AAOhsLPkAMEFVwXDXsg2VXr6FDgBAx1kfH22yvp0Rv0k7RFNyfHfxNbHmw5oPAABf9/5u3+x54zNZ8+kiURkZ2gkRybty5QPaDQAA2CFt1qy5LVX8uiqAyMORD1Q42ZCCza5Ij90u57+FzgdUAAB00K92euc9fWv8VhFp0G7R5HRoF+jqnxKzR3iPAgCgLdannuYRA1JiOfJBuBjZWF4+XjsCAAA7JBUULNNuAICuwJEPAFNUTx3ueuk91nwAAAiGtbe6Kf+qPmav+STGdpeGZqPXfA6w5gMAQNuKdvsKH7shs1JEDmq3RJqo1FTthIhTs3z5E9oNAADYIamg4FURadXuAICuwJEPVDjF8K9DQ8WV6XGs+QAAEKR1O73zfvK9+DIROa7dosvs99f+KbGs+QAA0DbrQF3z8G+lxHLkg1CXcXLLlsnaEQAA2MF1991Pt9bXa2cAQJfgyAeASWpZ8wEAIGjWX6qbRl/ZJ87oNZ+EGKc0njmnnaGJNR8AANpRtNtXOOeGzD0ickC7JZJ4331XOyHSLNAOAADADoljxxaLSLV2BwB0FY58oMLp1C6Aqa7KiCuTSr6FDgBAMNbt8s5bOCF7u4h4tVs0Ocwe85FvpbLmAwBAO6y/epqH9k+J5cinE8Xk5GgnRJRjL774Q+0GAADs4Jo58yetJ05oZwBAl+HUAoBpvNOudr2kHQEAQJix/lJ9enQgIGLyEx9l/F+fDkwZlrxCOwIAgFBU5PYVisgA7Q6gHRz4AACMkDBqVImIuLU7AKArseQDFaZ/Cxq6rsqIKxO+hQ4AQFDeq/TO+edbsreLSK12iybTX2MvS4mtFN6jAABoi3WwrnloP1cMaz6dJCo7WzshYtSvXTtJuwEAADv0njTpF/5jx7QzAKBLGf9VVABG8t5xtWupdgQAAGHG2nfs9MhzgYCY/MR0N/3MRw6y5gMAQNu+WPMZqN0BfMX4xvLy8doRAADYpFg7AAC6Gks+UOFkygfKvp0ZXya7vHwLHQCAILxX6Z2z4OasChGp1m7RZPqb7ADWfAAAaI/1uffM4JzkmP3aIZGge2qqdkJE8LzyymztBgAA7JA2a9bclqoq7QwA6HKOQCCg3QAD7Tp8SjsBkD9XN01Yt9P7W+0OAADCScFw15SBabHF2h3azraa/feoA3XNtxft9m3Q7gAAIASV/ui7GT8QkX3aIeHu2qoK7YRIMPDgjBmfaEcAAGCHK7Zs6S4irdodMEvclVdqJ8BALPlARTfTv/6MkDA0M7503U7WfAAACMaGSu/s+Tdl7RARs78aZfj77IBU1nwAAGiHdch3ZlDf5BiOfC5Rd5dLOyHs1a5YsUi7AQAAOyQVFLwqHPgAMARLPlDhPsKSD0LD3qOnb1q7s+532h0AAIST24clT7k8La5Yu0PbOcP/LnXAw5oPAADtKC1kzeeSjW4+qJ0Q7hI/vfnmE9oRAADYYUBRUaYY/vPy0JEwapR2AgzEkg9UOByGf/UZIWNIVvzWtTv5FjoAAMF4f7dv9uM3Zu0SkUPaLZqchr/TDkyLqxDWfAAAaIt12HdmUFbvaI58LoFvzRrthHC3QDsAAAA79Bwzplg48AFgEJZ8oGJPVZN2AvDf9h5tuundCtZ8AAAIxu3DkqcMSI0t1u7QZvrx+qe1pye/v9tXpN0BAEAIKv0nq88/iche7ZBwNezf39ZOCGvVS5bwD/8AACP0+9d/zROR7dodMFPSbbdpJ8BATu0AmMnp4OEJnWdoVnypnP8WOgAA6KD3d/tmi0iOdgd0XZ4Wt0t4jwIAoC3WkeMtAwMiwnNxDy7JfdoBAADYISEvr0Q48AFgGH6uCwBEmqdfm7JkzY46fmoCAICOsz71NI+4LCXW6J/skkBAujkd2hWaDt0+LHnZ+7t9vEcBAPAVxW5f4Q+tPp+JiFu7JRxFZWRoJ4Qt3zvvTNduAADADom33LLSX80vdQEwC0c+UOE0/GcNEHpys3psWbOjrlRE+IAKAIAOKtrtK5x7Q2aliBzUbtFk+pvtwLS4HXJ+zYf3KAAAvsyqOt5yWUavaI58YCersbx8vHYEAAA2WasdAAB248gHAM7zz7g2Zclq1nwAAAiG9Vld8/D+rlijj3xaWgMS3c3oU58q1nwAAGhbsdtX+IO/73NQRCq1W8JNVGamdkJYql2+fI52AwAAdkh9+OFF/qoq7QwAsB1HPlDhdGoXAF83rG+PzatZ8wEAIChFu32FPx6XuUdEDmi3QA9rPgAAtMuqPtHSPyMxiiMf2CHrZGnpRO0IAADskHTHHUu1GwBAA0c+APA/Wu+5LvXptz/yLBQ+oAIAoKOsg3XNQ/u5Yow+8mk+G5DY7kZfsrPmAwBAO4rdvsIfXJ/Omk+QuicnayeEndqXX35KuwEAADv0njhxlYg0a3cAgAaOfADgyzaLyELtCAAAwkmR21c4e2zGXhHZr92iyWH0L3aJXJHOmg8AAO2wqhv8/dNZ80HX6la/YcOj2hEAANjBNXPmotb6eu0MAFDBkQ9UfFzVpJ0AtMnhEJk5MnXRW9s9i4UPqAAA6Cjrc++ZwTnJMUYf+TS1nJP4aLPXfAqGu5ZtqPTyDgUAwFcUu32Fj1yffkhEKrRbwkX9hg3aCeFmtnYAAAB26GlZG0XkkHYHAGjhyAcAvq5UOwAAgHBT5PYV/ui7GftEZJ92C/QMTItlzQcAgLZZNQ3+nLSeURz5dFB0VpZ2Qlg58sQTL2o3AABgh6Rp017y19RoZwCAGqO/Zgo9DgcPT2g/9+alLhKOfQAACIZ1yHdm0LlAQEx+Gs+0av/noK2qYLhrmXYEAAChqNjtKxSREdodiEiTtQMAALBDQl5eifDZDQDDseQDAG3jJREAgCAVuX2Fs8b02S8ie7VbNDkc2gW6rkiP3S6s+QAA0Bar9qQ/JzWBNZ+OiOrTRzshbHhee+0ftRsAALBD4i23rDzr9WpnAIAqjnygwmn6Jx8IC/ePSnvqjW21zwgfUAEA0FHW4fqWgVm9o40+8jlxulV6xXXTztBUPXW466X3Kr28QwEA8BXFbl/h97+TXiUi27VbEDFyG7dtG68dAQCATdZqBwCANo58AKB9W7UDAAAIN8VuX+EPrT6fiYhbu0WT6SftV6THVghrPgAAtMXyNPqzUnrwz7LfpHtKinZCWKhZvnyBdgMAAHZIffjhRf6qKu0MAFDnCAQC2g0wUJHbp50AdNTolWW1zwofUAEA0GGTc5MLMhKj3tfu0JZs+Id3n9Q0T3yv0vtr7Q4AAEJQ6UOj0x4X1nwu6Ab/X7UTwoHr01tvrdOOAADADgM//DBORJq1O4C/FT94sHYCDGT2vzoDwDcr0w4AACDcFLt9hT+4Pv2giFRqt2hyGP4TtVf2idsurPkAANAW6/Wy2ucfGJ02RjsklP0h6ltyzap/0c4IdU9pBwAAYIfeEyeuEg58AEBEOPKBEqd2ABCEh0anPf56We3zwgdUAAB0lFXd4O+fnhhl9JGPp9EvqQlR2hmaaqcOd730XqWXdygAANo2Wvhy0QVFZ2VpJ4S0Yy++OFu7AQAAO7hmzlzUWl+vnQEAIYFbCwD4Ztsn5yav0I4AACCcFLt9hSIyQrtDm8PwZ9D/rPkAAIAvs1aW1T4rARGeCzy4kB9qBwAAYIeelrVRRA5pdwBAqGDJByqcTrN/ugDhJ61n1CHh5yYAAAiGVdPgz0nrGVWhHaKp5qRf0nuy5sOaDwAA7WLN5wKisrO1E0JW/dq1k7QbAACwQ9K0aS/5a2q0MwAgZLDkAwAdU8GaDwAAwWHN5zyHw+znqoy4MmHNBwCAtlgrt9U+ey4QEJ62H7RrfGN5+XjtCAAAulpCXl6J8G8KAPAlLPlAhYMhH4Sh9ETWfAAACJJVe9Kfk5LQ3eg1n6MnWiSzV7R2hibvtKtdL63fxZoPAADtyBeRrdoRoSg6K0s7ISTVLF8+W7sBAAA79Bw3bo2/ulo7AwBCCks+ANBxrPkAABCkL9Z8Rmp3QNegPqz5AADQDmtVueeZgIjwfP1Bm3Iat26doB0BAIBNVmkHAECoYckHKpxM+SBMZfSKPiis+QAAEAzr9T/VPv/g6LQx2iGaqo63SFZv1nxY8wEAoF2WcBD7Nd2SkrQTQk7t8uWLtRsAALCDa+bMpS2HD2tnAEDI4cgHAIJTOTk3eUWx28cHVAAABGe0iJRpR2gy/c79qoz/XvPhPQoAgC+z3iz3LJ45MnWMdghCXuzxjRvv044AAMAOydOnL9FuAIBQxJEPVDgN/4AD4S2rd/RnwgdUAAAEw/plWe2z948ye83nkK9FcpLNXvO542rX0nWs+QAA0B7WfL6ift067YRQM087AAAAO/SaMGGNiDRodwBAKOLIBwCC52bNBwCAi5IvIlu1IzQ5xOxr96sy4stEvBxLAwDwddZb2z2L77mONZ+/FZWVpZ0QUo4uWsRPdQEAjJA8Y8bis16vdgYAhCSOfKCCJR+Eu75J0fuFNR8AAIJhvbGt9pl788z+4Oqgt1n6u2K1MzQdZ80HAIALGisim7UjEJLu1A4AAMAOCfn5m0Rkv3YHAIQqjnwA4OLsnZKbvKKINR8AAIJl/M9QOAw/eP92ZnyZ7GLNBwCANlhvf+RZeM91qZuHZsdrt4SEqKoM7YSQ4V258gHtBgAA7JA0deqysx6PdgYAhCyOfKDCafonG4gIOckx+4Q1HwAAgmG9We5ZPHOk2Ws+n3ma5bJUw9d8rnEtXbeTNR8AANrBmg++amRjefl47QgAALpaQl5eiYiUaHcAQCjjyAcALt4+1nwAALgorPloBygbnBG/dZ2w5gMAQBustz/yLHwhu1+piLRqx2iLSk3VTggJNcuXP6HdAACAHRLy8z/wHzminQEAIY0jH6hwmv6pBiLG37li9gprPgAABMN6a7tn8T3Xmb3m82lts1yeZvSaTwNrPgAAtMvaffjU2NzsHnyLHSIiGSe3bJmsHQEAgE1+rh0AAKGOIx8AuDT7WfMBAOCiGP8zFKb/gu2QzPit63ay5gMAQFtW76hbkJvdY7MYvubTLSlJO0Fd7csvL9RuAADADq577lnqr6nRzgCAkOcIBALaDTDQlk8btBOAzjTgpQ+Pvi58QAUAQDBK774udczQrHjtDlVnzp7TTlC192jThF/t9P5WuwMAgFA049qUG4dkxRu95vOtE4e0E7R1+2TMmLPaEQAA2OHy3/2ul4jwASLCSo9hw7QTYCCWfADg0h2YMix5RdFu1nwAAAgSaz7aAcqGZMaX/oo1HwAA2rR6R92Cn2blbBERv3aLlvoNG7QTtM3WDgAAwA69JkxYIxz4AECHsOQDFf8fSz6IPP1f+PDoG8IHVAAABKN06ZR+48Twn6FoMXzN52PWfAAAaNddI1JuHpoV/3vtDi0ZW4q1E1Qd/vGP+cd7AIAR+q9efYWI7NfuAILVa9w47QQYyKkdAAAR4uCUYckrtCMAAAgzlvvIqbHnAgEx+THdkMz4UhEp1e4AACAUvVtRN19EYrU7oOIm7QAAAOyQkJ+/STjwAYAO4+e6oMLpNP2HCRCJBqbFVcj5D6hY8wEAoIP4GQqR7t0ccrbV6GOfU3dek/Lc2p11vEMBAPB11p6qJmtwpplrPt3T07UT1HheeaVQuwEAADskTZ267KzHo50BAGGDJR8A6DyHbh+WvEw7AgCAMGO5jzSNPRcQMflxOBxGP0Oy4rcKaz4AALTpizWfHtodsNXAxq1bJ2hHAADQ1RLy8kpEpES7AwDCCUs+UMGQDyLVFelxO4Q1HwAAgvJuRd38IVk5pSLSrN2ixeEQMfyXu07dOSLlubUVrPkAANAG6+OjTfmDM+KMW/Pp7nJpJ6ioXbFikXYDAAB2SMjP/8B/5Ih2BgCEFZZ8AKBzVRUMdy3TjgAAIMxYe6qarEDg/KGLqY/phmSy5gMAQHvWsuZjksQTmzZN144AAMAmP9cOAIBww5IPVDhY8kEEuyI9druw5gMAQFDWVtTNH3JbzlYROaXdAjWs+QAA0D7r46NN1uDM+E3aIXb6NOVyca1YrJ1htwXaAQAA2CH5rruWtVRVaWcAQNhxBPjKKBRsO3hSOwHoUvtrmie+V+n9tXYHAADh5M5rUm7+dqZ5P0Pxt7rxu7axT35w6HfCsTQAAG0p/ZeJfW8TkQbtEDtlFK3UTrBV9ZIl/IM9AMAIl//mNyki4tXuAC5FjxEjtBNgIJZ8oMLJlA8i3JV94ljzAQAgSGt31s3/l8y+28SwD67+Vuu5gOmHPs13jUh57l3WfAAAaIv18dGm/G9nmLXmY5j7tAMAALBD4vjx64UDHwC4KBz5AEDXqJ063PXSe5VePqACAKDj+OBK+Eva0Kz40ncrOJYGAKAt63Z65y2+Nb5MRI5rt9jFEROjnWCnZu0AAADs4JoxY8nZujrtDAAIS07tAJjJ6eDhifznqoy4Mjm/5gMAADpo3U7vPBHprd2hqaXV+F9oaL5rRMpz2hEAAIQo689Hm0YHAiKmPIdvnqH9Z26ntQl5eSXaEQAAdKWEUaNKRMSt3QEA4cr0L4kCQFfyTrva9dL6Xaz5AAAQBOvPR5tGD8qIM3rNx2H4z9vmZsdvZs0HAIC2rdvlnfeT75m15uOMi9NOsE3vgoJljeXl47U7AADoKr0nTfqF/9gx7QwACFss+UCF0+Hg4THi+XZG/B+FNR8AAIKybpd3noi4tDs0nfaf007Q5p9+bcoS7QgAAEKU9ZfqptHnAgEx5Tn491O0/8zttOmLhQMAACJVsXYAAIQzlnwAoGsdv+Nq19J1rPkAABAM6y/Vp0cP6hO3UTtEk0MMX/PJ6rFlzY461nwAAGjDul3eeQsnZG8XEa92i10c0dHaCbZJuvPOnzZu28aaDwAg4qTNmjW3papKOwMAwpojEAhoN8BAlYdPaScAdkpc+JvDvxY+oAIAIBilCydkF4hBH1y1pUd0N+0EVXuqTo1fvaPuD9odAACEomlXu24z7Sj6W+W/1U6wTf369b9t3Lp1gnYHAACd6YotW7qLSKt2B9BZ4q68UjsBBmLJBwC6XsM/XONa+qudrPkAABAE6y/Vp0dfmW7WB1df5TB7zEdys3tsXs2aDwAAbVq/yztn4YTsMjHoKNoZE6OdYBvX3Xcv4cgHABBJkgoKXhUOfADgkrHkAxXuIyz5wDg9ntp4+LfCB1QAAASj9Kmbs+8QkVrtEE2JcWav+biPsOYDAEB7pg533XalYWs+A3d/qJ1gG9+77/76ZGnpRO0OAAA6w4CiokwRqdbuADpTwqhR2gkwkFM7AAAMcerOESnPaUcAABBmrP+oOT2yNRAQkx/T5Wb32CwipdodAACEovcqvXNEJE27w06O6GhjHte99y7S/vMGAKAzJI4b975w4AMAnYIlH6jYU9WknQBo6LHg14dY8wEAIDil82/KmiEiVdohmpLizf6l5T1VTWPf+cjz79odAACEoqnDXbcNTI81as1n0L4/aifYxvvWW0Unt2yZrN0BAMCl6L9q1TARcWt3AJ2t1803ayfAQCz5AIB9Tt3Fmg8AAMGy9tc2XxsIiJj8OBxmP7nZ8aXCmg8AAG36Ys0nQ7vDTo6oKGOelAcffFL7zxsAgEuRMGpUiXDgAwCdhiUfqNh7lCUfGCt2/geHfies+QAAEIzSJ25kzceVYPiaz5GmsW9/5FkovEcBAPA1BcNdUwamxRZrd9jp25+VayfYxvvWW+saSkqmaXcAAHAxsn/60ykiUqzdAXSFlPvu006AgVjyAQB7NU+/NmWJdgQAAGHG2l97+tqAiJj81DWevfQ/yfC2WTsAAIBQtaHSO1tEsrQ77OSIjjbmSXnooce1/7wBALgExdoBABBJWPKBin3HTmsnAJq6zSv6/N+Fb6EDABCM0sdvzJopIoe0QzQdPd6inaCNNR8AANpRMNw15fJUs9Z8hhzZpZ1gG++bb64+sWnTdO0OAACCkTZr1lwReUm7A+gqmQsWaCfAQBz5QAVHPjDdnqqmse985Pl37Q4AAMLJlGHJBQNSYt/X7tB2rMGvnaDq7Y88W4QjHwAA2mLcT5wOrd2rnWCnjM+mTDmqHQEAQDCu2LKlu4i0ancAXSXuyiu1E2Agfq4LKhwOHh6zn9zs+FIRKdX+/xcBAAgnRbt9hSLSX7tDncPs556RqU8L71EAALTFuJ84dacN7qQ/urBQ3XvixFXaEQAAdFRSQcGrwoEPAHQ6lnyg4j9qWPIB9hxp4ucmAAAI0pRhyQX9Xaz5eBoNX/PZzpoPAADtMO4nTofXf6KdYCfXp7feWqcdAQBARwwoKsoUkWrtDqArJYwapZ0AA7HkAwB6NmsHAAAQbr5Y8xmg3aEtBAZ1VJ+ZI1MXCWs+AAC0xdpfe3rEuUBATHl29h6o/WduJ2/S1KmvakcAAPBNeo4ZUywc+ABAl2DJByrW7/JqJwChwnpru2ex8E10AAA6bEpucsHfuWKMX/PxnjqrnaDqLdZ8AABoT+lj4zPvF5GD2iF2uabxr9oJdkr89OabT2hHAABwIf3+9V/zRGS7dgfQ1ZJuu007AQZiyQcAdPENdAAAglTk9hWKiFFf2W6Lw2H2c28eaz4AALTDOuBpHh4IiJjyVPT4lvafuZ0aku+6a5l2BAAA7UnIyysRDnwAoMt01w6AmRwO7QIgdNybl7rozXLWfAAACIL1n94zg3OSY/Zrh2jqHdddjp82es2HAx8AANpRtNtXOPeGzEoxaM3HGRWlnWCb1Icemud7993Z2h0AALQl8ZZbVvqr+aUuAOgqLPkAgD4+oAIAIEhfrPkM0u6ALtZ8AABol/VZXfPwgIiY8myP7ttJf3Rhwe+6//4l2hEAALRjrXYAAEQylnygwsmUD/Al949Ke+qNbbXPCGs+AAB0lHXId2ZQ36TofdohmnrFdpMTza3aGZo48AEAoB1Fu32Fc27I3CMiB7Rb0CWeEpEF2hEAAPyt1IcfXuSvqtLOAICI5ggEAtoNMND7u33aCUDIeWNb7RbhyAcAgGCUFo7p8wMRMfrQx/AjHxERi58+BQCgbVNykwv6p8S8r91hp4Gr/7d2gp0WeF577RntCAAA/svADz+ME5Fm7Q7ALvGDB2snwEAs+UCFkyEf4GseHJ325C/Lap8VPqACAKCjrEP1LYOyepu95pMQ000azxh96MOaDwAA7Shy+wp/PC6DNZ/ItUREOPIBAISE3hMnrhIOfACgy7HkAxXFbpZ8gLb8sow1HwAAglT6Q6vPj0TErR2i6ZTZRz4iIvmryj389CkAAG2Ykptc0M9l1prPoPd+pp1gpzm1L7/8onYEAACXrV/fT0QOaXcAdup5/fXaCTCQUzsAZnI4eHh42noe+k7a48K30QEACIZVdbzlsnMBEZOfuOhu2v85aNuqHQAAQKgqcvsKRWSgdge6zEvaAQAA9LSsjcKBDwDYgiUfqPhgD0s+QHvqGs/eXuz2bdDuAAAgjJT+4O/7/C8RqdQO0dTsP6edoC3/jW21rPkAANCGKbnJBTnJZq35DP7t69oJdnr02AsvvKIdAQAwV87PfjZG+AIzDJQ8dap2AgzUXTsAZnI6HNoJQMhK6xl1SM6/DPMBFQAAHWNVn2jp3ycxyugjn5juDjlz1ugvcbDmAwBAO4rcvsIffTdjn4js025Bl3g1IS/v9sby8vHaIQAA8yTk5ZUIBz4AYBuWfKBi48f12glASKs96WfNBwCA4JQ+en268Ws+LWYf+YiIjF65rfZZ4VgaAICvmZKbXNA3KdqoNZ+hH76tnWCn+6qXLHlDOwIAYJ7MxYvvEpG12h2AhrRHHtFOgIFY8oEKJ0M+wAX1SYw6KKz5AAAQDOtYg79/Wk+z13y6d3PI2VajD33KtAMAAAhVRW5fYeGYPqz5RK5VCXl501nzAQAo4MAHAGzEkg9U/HYvSz7ANznWwJoPAABBKn04P32uiFRoh2gy/MhHhDUfAADaNTk3uSC7t1lrPsO3rtNOsNOdRxcufFc7AgBgjtSHH14kIk9rdwBasp7mv/6wH0s+UOFwMOUDfJOMXtGs+QAAEByr9qQ/JzUhyugjn25Oh7SeM/rQhzUfAADaUez2Ff6T1We/iOzVbkGXWJuQl/cAaz4AALsk3XHHUu0GADANSz5QsenPx7UTgLBQfaKFNR8AAIJT+v3vpD8uItu1QzSd4+95o39ZxpoPAABtmZybXJBl2JrPiJ0btRPsNOHIY4/9VjsCABD5ek+cuCrtRz+6X7sD0BQ/eLB2AgzEkg9UOBnyATokq3f0Z8KaDwAAwbD+7U81zz84Om2MdghUseYDAEA7it2+wh9afT4TEbd2C7rEpoRRo0oat21jzQcA0KVcM2cuaq2v184AAOM4tQMAABfknpybvEI7AgCAMDRaO0Cbw/DnodFpj8v5Y2kAAPBlVtXxlsvOBURMeT66eqI4oqONeZLuvPOn2v8lAwBEtp6WtVFEDml3AICJWPKBim4s+QAdlpMUvU9Y8wEAIBjWL8tqn31glNlrPgExfkHT6J9sAwDgQordvsIf/H2fgyJSqd2CLrE5IT9/U+PWrRO0QwAAkSlp2rSX/DU12hkAYCSOfAAg9O2bkpu8osjt48gHAIDgjBbTf7bJ7CMfeeg7aY+//qfa54VjaQAAvsqqPtHSv09ilDFHPuXfvlFGHzBn5M91991LOPIBAHSFhLy8EmE5FwDUcOQDFQ6H4Z82AEHKSY5hzQcAgOBYK7fVPntfXuoY7RBN51pFups9o7l9cm7yimKOpQEA+Jpit6/w0evTWfOJXGU9LWvjydLSidohAIDI0nPcuDX+6mrtDAAwFkc+ABAeWPMBAODi5IvIVu0ITQ7D53xSE6KqhGNpAADaYh1r8PdPN2jN508DLMk/tE07wzaue+9dxJEPAKALrNIOAACTceQDFd2c2gVA+OmfErNH+IAKAIBgWKvKPc/ca/iaT0vrOYk2+wWcNR8AANpR7PYVPnJ9+iERqdBuQZeo7DlmTPHJLVsma4cAACKDa+bMpS2HD2tnAIDROPIBgPBxgDUfAAAuiiWG/1a86b+Wm9Yz6pBwLA0AQFusmgZ/TlrPKGOOfP7Yd5T8/TFj/j9XUh588EmOfAAAnSV5+vQl2g0AYDqjv84JPQ6Hg4eH5yKeb6XG/teaDwAA6BjrzXLP4nMBEZOf0/5z2v85aKuYnJu8QjsCAIBQVOz2FYrICO0OdJl9iePHr9eOAACEv14TJqwRkQbtDgAwHUs+ABBeDkwZlryiaDdrPgAABGmsiGzWjoAe1nwAAGiXVXvSn5OS0N2YeZst6dfId+s/1s6wTcpDDz3eUFIyTbsDABDekmfMWHzW69XOAADjceQDFU7Dfy4AuBQDUmMrhQ+oAAAIhvX2ds/Ce65L3TwkK167RdUBT7N2gqaKybnJK4r56VMAAL6m2O0rfOg7aVUisl27BV3iYK8JE9ac2LRpunYIACA8JeTnbxKR/dodAACOfAAgHB1kzQcAgIti/JqPw/Bj+/RE1nwAAGiH9fqfap9/aHTaGO0Qu/y/3kNkbNMn2hm2Sfn+9+dy5AMAuFhJU6cuO+vxaGcAAETEqR0AMzkdDh4enkt4BqbFVcj5D6gAAEDHWG9/5FkoIt20QzRdlhKrnaCtYnJu8grtCAAAQthI7QB0mereEyeu0o4AAISfhLy8EhEp0e4AAJznCAQC2g0w0NbPTmonAGHv09rTk9/f7SvS7gAAIJzMuDblxqFZPYz+h6mDXqN/sktEZPirf6z5P8KaDwAAbSl9YJQ5az4iIjee/at2gp1cn956a512BAAgvPSZO/efROTn2h1AKOozd652AgzEkg9UOB08PDyX+lyRHrdDWPMBACAoq3fULRCRKO0OTf1dxq/5VLLmAwDABY3WDkCX8SZNnfqqdgQAIOxw4AMAIYQlH6go+ytLPkBn2F/bPHlDpZc1HwAAgjD92pQbh2TGG73m87nvjHaCNtZ8AABoX+n9hq353CSHtBPslPjpzTef0I4AAIQH1z33LBWRx7U7gFDV94UXtBNgoO7aATCTw6FdAESGK9Jjt8v5NR8+oAIAoIPW7Khb8NyknD+KiLG/W9UvOcb0Q5/KybnJK4rdPt6hAABoW76IbNWOQJdoSL7rrmW+d9+drR0CAAh9yTNmLNFuAAB8GUs+ULHtIEs+QGfZX9M88b1K76+1OwAACCd3jki5eUhm/O+1OzQdqTf6yEdEZPgrrPkAANCe0vvyUsdoR9hpQvQx7QQ7RX0yblyLdgQAILT1mjBhTVph4QztDiCU9Rg2TDsBBmLJByq6MeUDdJpBfeJY8wEAIEhrK+rmD7ktZ6uInNJu0ZKdFGP6oQ9rPgAAXBhrPpHL77r//iXeN95YoB0CAAhdyTNmLD7r9WpnAAC+wqkdAAC4ZLVTh7te0o4AACDMWB9XNeUHAgEx+RGHw+gno1f0QTl/LA0AAL7MWlXueSYgIqY8v23p00l/dGHjKe0AAEDoSsjP3yQi+7U7AABfx5IPVDDkA3SuqzLiyqSSNR8AAIKxdmfd/Gcy+xq95pPVK0qqTvi1MzSx5gMAwIVZYtBBrG/dOu0E2zijoyX1kUee8rz22jPaLQCA0JM0deqysx6PdgYAoA0s+QBAZPDecbVrqXYEAABhxtpztMk6FxAx+XE6zH6yekd/JgZ9eAkAQBCsN8s9iwMBEVOeskmF2n/mdluiHQAACD0JeXklIlKi3QEAaBtLPlDhZMoH6HRXZcSXiXhZ8wEAIAjrdnrnDb41fquINGi3aEnvGSU1J41e83Gz5gMAwAUZtebjiI7WTrBV2qxZc2tffvlF7Q4AQOhIyM//wH/kiHYGAKAdLPkAQOQ4fsc1rPkAABAka+/RpnztNR3tx3Ss+QAA0C7rre1mrflsvflR7T9zu72kHQAACDk/1w4AALSPJR+ocDLkA3SJwRnxW9ex5gMAQFDW7fLO+8n34stE5Lh2i5bUhCjxNLLmw5oPAADtGisim7Uj7OKMjdVOsFWfxx77wbEXXnhFuwMAoC/5rruWtVRVaWcAAC7AEQjwtU3Yr/LwKe0EIGL9ubppwq92en+r3QEAQDiZdrXrtkF94jZqd2jynTqrnaBt8M9Kj/1MOJYGAKAtpfdclzpmSFa8dodtklb/QjvBVo1//OMfGsvLx2t3AAB0Xf6b36SIiFe7AwgXPUaM0E6AgVjygQqWfICuMyQzvvRXO1nzAQAgGOt3eecsnJBdJgb/Q1Zyj+6mH/rsZc0HAIALMmrNp37GP0ry+te1M2zTc9y4NRz5AIDZEsePXy8G/7sIAIQLjnwAIPKcunNEynNrK+r4gAoAgI6z/lJ9evSVhq/5OAw/xu+bFL1fRDiWBgDg66y3P/IsXDqlX6mItGrHoEusSsjLm86hDwCYyzVjxpKzdXXaGQCAb8DPdUHFx0ebtBOASBf75AeHfid8QAUAQDBKn7ol+w4RqdUO0XTitNFrPnKkvuX2Irdvg3YHAAChaMa1KTfmZvco0e6wk+vXb2sn2OnOowsXvqsdAQCwX8KoUSWpjzxyo3YHEG563XyzdgIMxJIPAESm5rtGpDz3Lms+AAAEw/qPY6dHDkyPNXzNx+w5n77JMfuENR8AANq0ekfdgtzsHpuFNZ9ItTYhL+8B1nwAwDy9J036hf/YMe0MAEAHsOQDFX+uZskHsEHUE8WHSoQPqAAACEbpkzdn3SUi1dohmhrPnNNOUHXYd4Y1HwAA2jH92pQbh2bFG7Xmk/6hUa8FE4489thvtSMAAPbK/ulPzf7GD3CRUu67TzsBBmLJBwAil3/GtSlLVu9gzQcAgCBYn9Q0jxyYFlusHaLJ9H/Zy2HNBwCAdq3ZUbdgaFbOFhHxa7egS2xKGDWqpHHbNtZ8AMAQabNmzW2pqtLOAAB0EEs+ULHv2GntBMAU3eYVff7vwgdUAAAEo3T+TVkzRMTof+FqajF7zecQaz4AALTrrhEpNw/Jiv+9doedMv9o1C+6jj38ox/9u3YEAMAeV2zZ0l34KU7gosRdeaV2Agzk1A4AAHSp1ruvS31azn8THQAAdIz1Sc3pa88FREx+HGL20y85Zq/wDgUAQJveraibLyKx2h3oMpsT8vM3aUcAALpeUkHBq8KBDwCEFZZ8oIIlH8A+e6qa5J2PPFuENR8AAIJR+viNWTNF5JB2iKYzfrPXfD5nzQcAgHbdOSLl5iGZZq359N3xB+0EO43+/NFH/6QdAQDoWgOKijJFpFq7AwhXCaNGaSfAQN21A2Cmj6uatBMAYzhE5J7rUp9++yPPQuHQBwCAjrL2154eMSA11ugjH3FoB+jq5/rvNR/eoQAA+Iq1FXXzh9yWs1VETmm3oEuU9bSsjSdLSydqhwAAukbiuHHvCwc+ABB2WPKBinU7vdoJgHHeZs0HAIBglT42PvN+ETmoHaLJ32r23xk/97LmAwBAe+4ckXLz4Iw4o9Z8+u0x6tc8h//nAw/s0o4AAHSN/qtWDRMRt3YHEM563XyzdgIM5NQOgJkcDh4eHrufmSNTF8n5b6IDAICOsQ54moefC4iY/DgdZj/9U2L2CO9QAAC0aW1F3XwR6aHdgS5T2XPMmGLtCABA50sYNapEOPABgLDEz3UBgDn4cAoAgCAV7fYVzrkhc4+IHNBu0eJwOMTwBdgDU3KTVxS5fSwiAgDwddbHR5uswZnxm7RD7PKfQy3pv69MO8M2KQ8++OTJLVsma3cAADpX70mTfuE/dkw7AwBwETjygQqnQ7sAMNN9ealPrSr3PCP8bBcAAB1l/dXTPLR/SoyxRz7nmf0C3z8l9r/WfHiHAgDgK3610ztvcGb8VhFp0G5Bl9iXOH78+oaSkmnaIQCATlWsHQAAuDgc+QCAWbZqBwAAEG6K3L7CH4/LMHrNRyQghh/6sOYDAED7rI+PNuV/O8OcNZ/PrhwtA/5aoZ1hm5SHHnqcIx8AiBxps2bNbamq0s4AAFwkjnygwukw+gMCQNUDo9KeXLmt9lnhm+gAAHSUdbDuzNB+yWav+XTrpl2g61uprPkAANCedTu98xbfGl8mIse1W9AlDvaaMGHNiU2bpmuHAAAuXVJBwTLtBgDAxXNqBwAAbGfOD8cDANBJity+QhEZqN2hqbU1oJ2g7cCUYckrtCMAAAhR1p+PNo0OBERMeT7tP0Ic0dHGPCnf//5c7f+SAQAuXVJBwasi0qrdAQC4eCz5QAVDPoCuB0enPfnLMtZ8AAAIgvW578zgvskx+7VDNJn+F8jLUmIrhTUfAADatG6Xd95PvseaTwSr7j1x4qrjGzfepx0CALh4rrvvfrq1vl47AwBwCVjyAQAzseYDAECQvljzGaTdoamFNZ+DrPkAANAu68/VTdefCwTElOc/MoeIMyrKmCf1kUdY8wGAMNZzzJhiEanW7gAAXBrTv4gJJU6mfAB13/9O+uP/9qea54VvogMA0FHWYd+ZQVm9o/dph6jqZva7PGs+AAC0b/0u75yFE7LLRMSr3YIu4U2aOvXV+vfee1Q7BAAQvOTp03/q93i0MwAAl4glHwAw1/bJuXwTHQCAYHyx5jNYu0NTs/+cdoI21nwAAGifte/Y6dGBgIgpz59TrhTp3t2YJ+Whhx7X/i8ZACB4CXl5JSKyXbsDAHDpWPKBCoZ8gNCQ1jPqkPBNdAAAgmEdOd4yMKt39F7tEE2mv84PYM0HAIB2rd/lnfPPt2RvF5Fa7RZ0iYbku+5a5nv33dnaIQCAjku85ZaV/mp+qQsAIgFLPgBgtgrWfAAACE7x+TWfXO0OTU2s+bDmAwBA+6x9x06PDIiIKc/e3gPEGRVlzJP60EPzOum/KwAA+6zVDgAAdA6WfKDCafpXf4EQ0icx6qDwTXQAAIJhVR1vuSwjMcqtHaLK8Hf6Aams+QAA0J73Kr1znmLNJ5L5Xfffv8T7xhsLtEMAAN8s9eGHF/mrqrQzAACdxBEIBLQbYKDf7q3XTgDwN441+G8vdvs2aHcAABBGSn9wffr/EpFK7RBNCbHdtBNUHfA03160m3coAADaMnW467aB6bEbtTvsNKzpkHaCbereeUe8b7zBhwsAEAYGfvhhnIg0a3cAkSh+8GDtBBiIJR+ocDoM/9ovEGIye0V/JnwTHQCAYFjVDf7+aT2jjD7yMf29fmBaXIXwDgUAQJveq/TOefLmrAoRqdZusYtv3TrtBNs4o6Ml9ZFHnvK89toz2i0AgPb1njhxlXDgAwARhSUfqPi/fz6unQDgK46eaGHNBwCA4JQ+nJ8+V0QqtEM0JcWb/d2RT2tPT35/t69IuwMAgFBUMNw1ZWBabLF2h536vfmidoKtPK+9xgcMABDCLlu/vp+ImDM1B9is5/XXayfAQGb/ayzUOM3+wi8QkrJ7R+8XvokOAEAwrNqT/pzUhCijj3xMd3la3C7hHQoAgDZtqPTOnn9T1g4RqdJusYsjOlo7wVZps2bNrX35ZbMumwAgTPS0rI3CgQ8ARByWfKDi9385rp0AoA1HjrPmAwBAkEq//530x0Vku3aIpuQeZn9/hDUfAADad/uw5CkD0+KKtTvs1H/tCu0EW9W+/DIfMgBACMr52c/GyPkvpQDoIslTp2onwEBm/0ss1DiZ8gFCUk5yzD7hm+gAAATD8jT6s1IMP3Ix/e1+YFrcDuEdCgCANr2/2zf7iRvNWvNxxsZqJ9iqz2OP/eDYCy+8ot0BAPgfCXl5JcKBDwBEJJZ8oKLkP05oJwBox2HfmduLWPMBACAYpQ+NTjN+zSclIUo7QdV+1nwAAGjX7cOSp1xu2JrPgOJ/1U6wVeMf//iHxvLy8dodAIDzMhcvvktE1mp3AJEu7ZFHtBNgILO/bgo1Tu0AAO3qlxyzV/gmOgAAwbBeL6t9/oFRaWO0QzQ5DJ/zuSKdNR8AANrz/m7f7MdvzNolIoe0W+ziiI7WTrBVz3Hj1nDkAwAhhQMfAIhQHPkAAL5q/5Tc5BVFbh8fUAEAEJzRIlKmHaGlpsEv6YlGr/lUFQx3LdtQ6eUdCgCAr7P2154eMSA11pgjn09uuVeu+L9vamfYaVVCXt50Dn0AQF/qww8v8lcZ8yuZAGAcjnygwsmUDxDS+qfE7BG+iQ4AQDCsldtqn73f8DUf0w1Mi2XNBwCAdhTt9hU+Nj6zUkQOarfYxRETo51gq8QJE1Zy5AMA+pLuuGOpdgMAoOtwagEAaMuBKbnJK7QjAAAIQ/naAZqONfi1E7RVFQx3LdOOAAAgRFkHPM3DAwERU559371T+8/cbmsT8vJKtCMAwGS9J05cJSLN2h0AgK7Dkg9UOB0O7QQA3+Cy1NhK4ZvoAAAEw3pjW+0z9+aljtEO0WT6q/4V6bHbhXcoAADaVLTbVzj3BrPWfJxxcdoJtupdULCMNR8A0OOaOXNRa329dgYAoAux5AMAaM/BKcNY8wEA4CIYfdxRdbxFO0Fb9dThrpe0IwAACFHWZ3XNw88FREx5Ph45SfvP3G6bEkaNYs0HABT0tKyNInJIuwMA0LVY8oEK07/dC4SLAaz5AAAQLOvNcs/imSMNX/PRDlB2RXpshfAOBQBAm4p2+wp/PC5zj4gc0G6xiyM6WjvBVkl33vnTxm3bWPMBAJslTZv2kr+mRjsDANDFWPIBAFzIwduHJS/TjgAAIAwZfdxxuJ41H9Z8AABol3WwrnmoSEBMefYMv7mz/uzCxeaE/PxN2hEAYJKEvLwSOf9lEwBAhGPJByqcTPkAYePytLhdwjfRAQAIhvXWds/ie65LHTM0O167Rc2J063aCaqu7BO3XXiHAgCgTUVuX+GPx2UYtebjjInRTrCV6+67lzRu3TpBuwMATNFz3Lg1/upq7QwAgA1Y8gEAfJNDrPkAAHBRxmoHaOoV1007QVstaz4AALTLOlh3Zui5cyKmPLuu/K72n7ndynpa1kbtCAAwyCrtAACAPVjygQonQz5AWLkiPW6H8E10AACCYb39kWfhC9n9SkXE2Ekb01/7B7HmAwBAu4rcvsLZ383YKyL7tVvs4oiO1k6wleveexedLC2dqN0BAJHONXPm0pbDh7UzAAA2cQQCAe0GGKjsrye1EwAEaX9t8+QNld4i7Q4AAMLJjOtSbszN6lGi3aHpZLOxN04iIrLv2OmJ71V6f63dAQBAKJqSm1yQkxzzvnaHnUb89U/aCbbyvvVW0cktWyZrdwBAJLv8d7/rJSIN2h2AiXoMG6adAAOx5AMVLPkA4efK9Fi+iQ4AQJBWf1S3IHdKj81i8pqP4e/+V2XElUkl71AAALSlyO0r/NF3M/aJyD7tFrs4oqK0E2yV8uCDT3LkAwBdp9eECWuEAx8AMApLPlBRfpAlHyAcfVLTzDfRAQAI0vRrU24ckhlv9JrPaf857QRV+46dnrh+F+9QAAC0ZUpuckF2UrRRaz4jj+zQTrCV96231jWUlEzT7gCASNR/9eorxKCfvgRCTa9x47QTYCCWfKDCafrXeYEwNahPHGs+AAAEac2OugXPTcr5o4g0a7dAx6A+cWXCOxQAAG0qcvsKZ43ps19E9mq32MURHa2dYKuUhx56nCMfAOh8Cfn5m4QDHwAwDkc+AIBg1E672vXS+l1ePqACAKDjrD1VTdbgzPjfa4doienulDNnjV7z8fIOBQBAu6zD9S0Ds3tHG3Pksy01V0Z53NoZdjrYa8KENSc2bZquHQIAkSRp6tRlZz0e7QwAgM048oEKhnyA8MU30QEACN67FXXzl9yWs1VETmm3QAfvUAAAtK/Y7Sv8J4s1n0iW8v3vz+XIBwA6T0JeXomIGP3T4ABgKo58AADB8t5xtWvpOr6JDgBAMKyPjzblD86IM3bNJ7qbQ1paA9oZmljzAQCgfdaR4y0Dswxa8/lTr0HynRP7tDPsVN174sRVxzduvE87BAAiQUJ+/gf+I0e0MwAACjjygQonUz5AWLsqI75MxMs30QEACMLairr5z0zsa/Saj+l/DbgqgzUfAADaU+z2Ff7Q6vOZiBjzO1bOqCjtBFulPvLIXI58AKDT/Fw7AACggyMfAMDFOH7HNa6l63byTXQAAIJgfXy0yfp2Rvwm7RAt3RwOaQ2YvebDIiIAAO2yqo63XJaRGGXMkU9p7GViNX+mnWEnb9LUqa/Wv/feo9ohABDOXDNnLvXX1mpnAACUOAJm/wMrlOw+YuyXl4FIkvjPGw//WvgmOgAAwSh9+ta+t4lIg3aIlnP8FbT3T357uFh4hwIAoC2lP7g+/X+JSKV2iF2ss59rJ9gt8dObbz6hHQEA4ezy3/2ulxj87wpAKOkxbJh2Agzk1A4AAISthn+4xrVUOwIAgDBj7a1uyj8XOH/sYuIDOX7H1bxDAQDQDqu6wd8/ICKmPFu69+ukP7qw0ZA8ffoy7QgACFe9JkxYIxz4AIDRWPKBij1VTdoJADpHjwW/PvRb4ZvoAAAEo/Qn3+s7WUSOK3eocTi0C9T1XvQb1nwAAGhH6aOGrfmMdRzVTrBb1CfjxrVoRwBAOOq/evUVIrJfuwPAeb3GjdNOgIFY8gEAXIpTd45IeU47AgCAMGP9pbpp9LlAQEx9Wpn0OX4Hi4gAALTHOtbg76+9Pmjn8+G5TO0/c7v5Xfffv0Q7AgDCTUJ+/ibhwAcAjNddOwBm4pu7QOQYmhVfurZCSoVvogMA0GHrdnnnLZyQvV1EvNotWkz/K8HgjPit68TLOxQAAG0odvsKH85PPyQiFdotdvnwXKbc4DRq0ecpEVmgHQEA4SRp6tRlZz0e7QwAgDKOfAAAl6r5rhEpz71bUccHVAAAdJz1l+rTowf1iduoHaLF3xqQqG5Gn/o03HGNa+m6nV7eoQAA+Dqr9qQ/J61nlDFHPiIivnXrtBNs44yOltRHHnnK89prz2i3AEA4SMjLKxGREu0OAIA+RyBg/Ew6FPy5ukk7AUDninqi+FCJ8E10AACCUfrPt2TfISK12iFaorsbfeQjIpL4zxsP/1p4hwIAoC2lD+enzxWD1nxERK5+b5l2gq08r73GBxQA0AF95s79JxH5uXYHgC/rM3eudgIMxJIPAKAz+Gdcm7Jk9Q7WfAAACIK179jpkVekxxq75tPsD0hslFM7Q1PDP1zjWvor1nwAAGiLVXvSn5OS0N2oIx9HdLR2gq3SZs2aW/vyyy9qdwBAGODABwAgIiz5QMm+Y6e1EwB0vm7zij7/d+Gb6AAABKN0wc1Zd4lItXaIljizj3xERHo8tfHwb4V3KAAA2lL60HfSHheR7dohdrp24yvaCbaqffllPqQAgAtIvuuuZSLyv7Q7AHxdzv/5P9oJMBBHPlDBkQ8QmfZUNY195yPPQuFDKgAAOqxguGvKwLTYYu0OTT2izT702Xv09E1rd9b9TrsDAIAQVfrg6LQx2hF2yvvwDe0Euz167IUXzLpsAoAgXP6b36SIiFe7A8DX9RgxQjsBBjL7X1IBAJ1ts3YAAADhZkOld7aIZGl3aHI4HEY/Q7Lit4pIqfZ/DgAAhLDR2gF2Kr/hfu0Eu72akJdXoh0BAKEocfz49cKBDwDgb7DkAxXrdvE+AkSwsW9vZ80HAIBg3D4secrlaXHF2h2aEmO7aSeo+vho001rK1jzAQCgHaUPjDJrzWf0H1drJ9jtvuolS4ybMAKAb9J/1aphIuLW7gDQtl4336ydAAOx5AMA6Gys+QAAEKT3d/tmi0iOdgf0DMlkzQcAgG9g1JpP2fUztBPstoo1HwD4soRRo0qEAx8AwFd01w6AmZwO7QIAXenevNRFb5Z7FgtrPgAAdJT1ae3pqwekxh7SDtFy4vRZ6RVn9F9RT905IuW5tRV1vD8BAPB11spttc/eb9iajyMmRjvBVokTJqxsLC8fr90BAKGi96RJv/AfO6adAQAIMSz5AAC6At9CBwAgSKz5iDgcZj9Ds+JLhfcoAAAuJF87wE5br5uqnWC3taz5AMCXFGsHAABCjyMQCGg3wEAbKr3aCQC6Xv6qcs8zwpoPAAAdNmVYcsFlKbHva3doSu5h9JqPfFzVdNO7FXW/0+4AACBEld6XlzpGO8JO1t5N2gl2m3Dkscd+qx0BANrSZs2aKyIvaXcAuLDMBQu0E2Ags//1FADQlbZqBwAAEG6KdvsK596QWSkiB7VbtJj+y75Ds+JL362QUuFQGgCA9uSLQf/mUDp4gmmHPpsSRo0qady2jZ/tAmC0pIKCZdoNAIDQxJEPVDgdpv/TPWCGB0alPblyW+2zwodUAAB0lPVZXfPw/q5YY498PI1nJTXB6L+qNt81IuW5dyvqeH8CAODrrFXlnmfuNWzNxxEdrZ1gq6Q77/wpRz4ATJZUUPCqiLRqdwAAQpPR/3IKAOhyZdoBAACEm6LdvsIfj8vcIyIHtFu0mP6dgNzs+M2s+QAAcEGWiJRqR9jl/w28Qb67/0PtDDttTsjP39S4desE7RAA0OC6++6nW+vrtTMAACHKEQgEtBtgoA/cPu0EAPYZ+XpZ7fPCh1QAAHTYlNzkgn6umPe1OzT1SYzSTlC1p6pp/JoddX/Q7gAAIESV3jPSrDWf8Yf+qJ1gt9GfP/ron7QjAMBuiePHr0/7x3+8Q7sDQMckjBqlnQADseQDAOhq2yfnJq8odvs48gEAoIOK3L7C2WMz9orIfu0WLQ4xe84nN6vHljU76ljzAQCgfWNFZLN2hF1Kcq437dCnrKdlbTxZWjpROwQA7OSaMWNJ64kT2hkAgBDGkQ9UOEzf3wcMk5oQVSXCT04AABAE63PvmcE5yTHGHvkcPdEimb2itTM0+Wdcm7Jk9Y463p8AAPg66+3tnoX3XJdqzJGPiIgj2qx3I9e99y7iyAeASRJGjSoREbd2BwAgtHHkAwCwA2s+AAAEqcjtK/zRdzP2icg+7RYtpn83IDe7x+bVrPkAAHAhRq35/CF9pNxYs107w06VPceMKT65Zctk7RAAsEPvSZN+4T92TDsDABDiOPKBGtP/wR4wTVrPqEPCmg8AAMGwDvnODMpOijb2yOdw/RnpmxSjnaGplTUfAADaZb39kWfh3delbh6aFa/dYhuHL0o7wVYpDz74JEc+AAxSrB0AAAh9HPkAAOxSwZoPAADBKXL7CmeN6bNfRPZqt0AHaz4AAHwjo9Z8jg7Jl8yPt2pn2Glf4vjx6xtKSqZphwBAV0qbNWtuS1WVdgYAIAw4AoGAdgMM9Os99eJwiHRjzQcwzfBX/ljzf4QPqQAA6LDJuckFWb2j39fu0NQv2eg1H3EfOTV+9Y66P2h3AAAQokqXTuk3TkRatUPskvXJR9oJduv/13/4h79qRwBAV7piy5buYtD/lgGRIu7KK7UTYCCndgAAwCiVk3OTV2hHAAAQTordvkIRydXugJ7c7B6b5fzPngIAgK+z3EdOjQ0EREx5jgy8TvvP3G4He02YsEY7AgC6SlJBwavCgQ8AoINY8oGKv13ycTqZ8wEMk/vz0mPLhTUfAAA6bHJuckFGYpTRaz79U2K1E1TtqWoa+85Hnn/X7gAAIESVPj+533gR8WuH2KXvf+7WTrBbxmdTphzVjgCArjCgqChTRKq1OwAEL2HUKO0EGIglHwCA3dys+QAAEJwv1nyGa3docjjMfnKz40uFNR8AANpjuatOjQmIOf936O+MG3qsTpo8+ZfaEQDQ2XqOGVMsHPgAAILQXTsAEBFhywcwS3bv6P1y/kMq1nwAAOgYq7rB3z89MapSO0TLAU+zDEg1es2n9Z7rUp9++yPPQuEdCgCAr1mzo27B0KycLWLQmo8zKko7wVYpDz30eH1x8YPaHQDQmZKnT/+p3+PRzgAAhBGWfAAAGvZOYc0HAICgfLHmM0K7Q9MBT7N2grbN2gEAAIQwy32kaey5gIgpz18zr9L+M7ebN2nq1Fe1IwCgsyTk5ZWIyHbtDgBAeGHJByHD6WTPBzBJ3+SYfcKaDwAAwbBqGvw5aT2jKrRDNO050qSdoIo1HwAA2vduRd38IVk5pSJizmVwd7P+iT/loYcer3/vvUe1OwCgMyTecstKfzW/1AUACA5LPgAALftY8wEAIDis+YjERRv/11jWfAAAaJ+1p6rJCgRETHk+Sx2o/Wdut4bk6dOXaUcAQCdZqx0AAAg/Zp35I+Qx5gOYpZ8rZq+w5gMAQDCs2pP+nJSE7kav+Yjhf2+4Z2Tq029vZ80HAIC2rK2omz/ktpytInJKu8Uuzqgo7QRbpT744DzfmjWztTsA4FKkPvzwIn9VlXYGACAMOQKBgHYDDPTrPfXicIh0c5z/mS6HnP9/OfIBzPO598ztRW7fBu0OAADCSOlD30l7XES2a4doOnPW7L/Lvr3ds0U48gEAoE13XpNy8+DMuN9rd9hp4In/1E6wVd077zzjfeONBdodAHCxBn74YZyY9POSQISKHzxYOwEGYskHIcfp4NIHMEn/lNg9wpoPAADBsF7/U+3zD45OG6Mdosn0vzXMHJm66K3tnsXCOxQAAF+zdmfd/Gcy+xq15rO/19+ZdujzlIhw5AMgLPWeOHGVcOADALhIHPkAALQdmDIseUXRbh8fUAEAEJzRIlKmHaElqptD/K1Gr/mUagcAABDCrI+PNlmDM+M3aYfYybdunXaCbZzR0ZL6yCNPeV577RntFgAIlmvmzEWt9fXaGQCAMMXPdUHFhX6uy+ngZ7sAA/V/8cOjbwjfRAcAIBil948ye83nHH+ftd4sZ80HAIB2lP7LxL63iUiDdoidUv9tqXaCrTyvvWb8CyGA8NLTsjam/dM/3abdAaBz9Lz+eu0EGIglHwBAKDjImg8AABclX0S2akdocTocph/6sOYDAED7rI+PNuV/O8OsNR9HdLR2gq3SZs2aW/vyyy9qdwBARyVNm/aSv6ZGOwMAEMZY8oGKjiz5sOYDGCdnacnRt4RvogMAEIzSe/NSx2hHQBVrPgAAtK908a19J4vIceUOW/V5a5l2gq1qX36ZDzkAhIWEvLyS5LvvvlG7A0DnSZ46VTsBBmLJBwAQKg7dPix52fus+QAAECxLWHQxGf/ZAwDQPuvPR5tGD8qIM2rNxxkbq51gqz6PPfaDYy+88Ip2BwB8k8Rbbll51uvVzgAAhDmndgBwIQ6Hg4eHx6Dn8rS4XcIHVQAABMN6s9yzOBAQMflxiNnPfXmpTwnvUAAAtGndLu88EXFpd9jpyLRHtBPs9mpC3v/P3t+HR13fef/3eyaZ3JEEksnkbgKWqijIjShIiLFfCmJrLBXkZjUgFkGsV0+z7Iqw3hQWV7Ri/V1c9NdWf6uItSIFNOn6W/bspstJthDuCQNUlGKpkRhIMhNuk5AQ5voD2rWVCRlMvu+ZfJ4Pj8/R8zjOrj6P0O1OZj7f1+SXa0cAQCes0Q4AAEQ/lnwAAJGENR8AAK6O0Ws+F4LGf93vZu0AAAAimPVhbXPBwOzED7RD7OSIi9NOsFXKuHGrz2zbNl67AwBC8cydu7itpkY7AwDQAziCQb6uFvb7t32N4nCIxDhEnE6HOOTivzodIk7Hn//14pKP4W/WAybyvvibmnfk4oeVAACgcyoevM0zRjtCU2yM8b84FL65te554TUUAACXU7GoKG+yiBj1HSn9/u1N7QRbnf6v//pPLvoAiFQDfvvbRBFp0e4A0LWSBg/WToCBWPIBAESaminD3a+sr/LzARUAAOEZKyIbtSO0nG8Pmn7RhzUfAABCM3PNJz5eO8FWqUVFK7nkAyAS9ZkwYZVwwQcA0EVY8oGKcJd8WPMBjJOz9H/XvCs8iQ4AQDgqZtzmGTPUm6TdoeajY83aCdoKVm6te0F4DQUAwOVU/PDuvGkiUqcdYqev/edq7QRbndqwgTUfABHn2nXrrhGRau0OAF0v5Y47tBNgIJZ8AACRqJY1HwAArorRaz43ZieaftGnUjsAAIAIZh081jzqxiyz1nyciYnaCbbqM3nyci75AIgkKZb1gXDBBwDQhVjygYqrWfJxOpjzAQyT+S//cXSt8CQ6AADhqFg26ZpxItKuHaLF8Es+Iqz5AADQkYpnv23ems+1m0u1E2x14v33//PM1q1c9AEQEfr93//3GBGp0O4A0D3Sp0zRToCBWPIBAESquqm3uF9Zt4c1HwAAwmD5jp4dO8SbVK4domVAVoIcOt6inaGJNR8AAEKzPjrePGpAVoJRaz6OuDjtBFul3X//j7jkAyASJOfnlwsXfAAAXYxLPogqTqd2AQA7DcpJrJSLvwRx0QcAgE56Z2fDMz/y9tskIm3aLVpMHwGdXZD59BuVrPkAAHA566v8Tzz9be8uEanVbrHLoduKZMCODdoZdtqYXFi44czmzUXaIQDMljJu3Oq2WmP+zw0AwCZc8gEARDL/tFvcy9ay5gMAQDgs39GmsUO8Sb/RDtFyrSdBPqlnzQcAAFyW9fHxllEDMhPKtEPs5IyP106wlXvGjKVc8gEQAVZpBwAAeh5HMBjUboCB/m1fozgcIjEOEafTIQ65+K9Oh4jT8ed/FXF84f/tdDjE6bz4rwCM0mfx//tZmfAkOgAA4ah44d5+3xYRY2+6/NHsSz4iIqNer6x7SXgNBQDA5VQ89S3vdBGp0Q6x08B9/6WdYKvAu+/+2+mKignaHQDM5J45c5mILNTuANC9+i5bpp0AA7HkAwCIdCem3epetnY3az4AAITB2lfTZA3JNXfNp39GghxpMPqiz3btAAAAIpj18fHmkQMyE4265OOIi9NOsJX7oYcWc8kHgJb04uKl2g0AgJ7JqR0AXI3/WffhcDgmnCG5SZtFpEL7v3sAAIgma3Y1PCUivbQ7VDnMPnNuz1wovIYCAOCy3t8bmCciXu0OO/3+hju0E+xWlTJmTJl2BADz9C4qWi0ip7Q7AAA9E0s+AIBocOr+WzNeXLO7gTUfAAA6z9pf01R4U26isWs+16THy6eBc9oZmljzAQAgNOtQXfPI601b83G5tBNslTF79tOnN22aqN0BwCzp06cvOe/3a2cAAHoolnwQtZwOB4fDMegM8bLmAwBAuNbsbnhKRFK1O6CHNR8AAEK7tObTT7vDTvu/nq+dYLeDqePHr9OOAGCO5MLCDSJySLsDANBzseQDAIgWZ+8fkfHiml2s+QAAEAZr/+dNhTflJG3QDtHSNy1ePms0e81n4rD0FWW+AK+hAAD4MutQXfOI6zwJ1dohdnImJGgn2Mozd+78U+XlU7U7AJghbcqU5efr67UzAAA9GEs+iGoOB4fDMekM9SZVCE+iAwAQlrW7/QtEpI92hyaH4X95kl01wmsoAAAuq3RvoERE+mt32KkqZ5h2gt2qexcVrdaOANDzJefnl4tIuXYHAKBnY8kHABBNWopHZixdvZM1HwAAwmD9/vOmgoE5icau+eT2ccnnJ9q0MzSx5gMAQGjW4fqW4ddmJBzRDrFVrFkfDWQ88sj8kxs2FGt3AOjZkgsLf9129Kh2BgCghzPrlTx6pBiHQzsBgI2GeXttWr2zoUJE+JAKAIBOWrvHv2DxPXnbRcSv3aLF9F8bMlNc1XJxzYfXUAAA/I3SvYGS+XfmVomIMRd99mTcJLc0/F47w061aRMnvtFYVjZbOwRAj/ZT7QAAQM/HJR8AQLRpmz4yY+k7rPkAABAO68Pa5oKB2YkfaIdoyU51ybFTRq/57GLNBwCAkKxPGlqG93ebtebjdLm0E2yVMWfOQi75AOgu7pkzl7XV1WlnALCRKzNTOwGG4pIPegTTn8oFTDMsr9fGd1jzAQAgLOv2+J9YVJRXKQav+ZiONR8AAEIr3Rso+cdxuftE5LB2i112pA6Q204d0s6wkz9typRXG9ev/752CICeJ724eKl2AwB7nf7tb7UTYCindgAAAFeh/cHbPM/JxQ+pAABA51gf1jYXXLggYurJTDbrafXL2DVxWPoK7QgAACKUdaShZahIUIw6sbFGnYw5cxZ20X9eAOAvehcVrRaRU9odAAAzsOQDAIhWG0VkkXYEAADRZH2V/4lnv523XUSM3RA3fQU0K5U1HwAAQin1BUr+cVyOWWs+Sf3ltiajvqXsVHpx8fLA6tXztEMA9Bzp06cvOe9nNBcwSazbrZ0Ag3HJBz3K/s+btBMA2MUh8uAoz3Nvb69fJHxIBQBAZ1kfHW8edX1mwgfaIVrSk2Il0HReO0PTronD0leU+QK8fgIA4MusIw3nhl6THm/MJR8REafLrLVDz+zZC7jkA6CrJBcWbhARo777EACgi0s+AIBoxpoPAABhWl/lf+Kpb3n3iEiNdosWw8d8JDvVdURY8wEA4LJKfYGSed/MOSAGfWBbGZMnBe1HtTPs1OaeNWup/803n9EOARD90qZMWX6+vl47A4CNYj0e7QQYjks+6HGcpr9jDxjmoXzP4re21S8RPqQCAKCzrEN1LSOv9yQYe8mnT2KsnGg2es2nijUfAABCsj4NnBvcNz3emEs+IiKbY/Kk0KyLPs+KCJd8AHwlyfn55SJSrt0BADALl3wAANGuQjsAAIBo816Vf94/3eXdKaz5GCuHNR8AAEIq9QVKSr6Zc1BEDmq32Cmwdq12gm2ccXHiefTRZ+tfe+157RYA0Su5sPDXbUeNuiAJGM+Vl6edAIhTOwDoDg4Oh2PU+V6+51nhsg8AAOGwDtU1jwyKiKknNdH4Z16qJg5LX6EdAQBAhLI+C5wbGAwGxaTz+/v/Qfvnbrel2gEAot5PtQMAAOYx/l1NAECPsFk7AACAaPP+3sC8hXd594hItXaLGodDu0BVTu841nwAAAih1BcoeXxM9iEROaDdYidHXJx2gq0yH398ft1PfvJj7Q4A0Sf9gQeWt9YYO44LGCnO69VOAESESz7owZyGv2EPmObh0ZlPr9xa94LwIRUAAJ1lHaprHnFdRoKxl3yS45xypvWCdoamqonD0leU+QK8fgIA4MuszxpbB3j7xBl1yWffpB/I0FKjhileEREu+QAIm3v6dL7uDzDM6U2btBMAEeGSDwCg56jUDgAAINqU7g2UPHlnbpWIHNFu0eI0/NkAb5+4T4Q1HwAALqvMFyj5gZX9iYj4tFvs5ExI0E6wVfaTTz527OWXf67dASB6pI4fv05E/NodAAAzcckHPZrpb9gDpplTkLnw9cq6l4QPqQAA6CzrcEPL8P7uBGMv+cTHOuXceaPXfHys+QAAEJJVc6L1Wm+fOKMu+ey9e7bc/B9vaGfY6dXk/Pz7zmzbNl47BEB0cE+fvvR8Q4N2BgAbxWZkaCcAf+HUDgAAoAttnzgsfYV2BAAA0aR0b6BERK7T7oCeL6z5AACAv1HmC5SIyDDtDrs54uKMOinjxq3W/pkDiA7Jo0eXi2ELbwCAyMKSD3o8h4M5H8AknmRXjfCVEwAAhMM60tAy9Gvu+MPaIVriYhzS2h7UztDEmg8AAKFZNSdar81JdRn1ge7ub86QW//PL7Uz7LQqOT+/mDUfAFfS5957f9Z27Jh2BgAbubKztROAv8IlHwBAT7OdD6kAAAhPqS9Q8g9jcw6IyCHtFi2mPxqQ1yfukHBRGgCAyyrzBUoeuyPriIhUabfYyREfr51gq9SiopVc8gHQCWXaAQAAs3HJB0Zw8sV0gFGyUl3VwodUAACEw/qT/9zgfunxxl7yiXE6pP2C0Ws+B7goDQBASFbtqbb+2akuoy757CyYKiMr12ln2GlNcn7+w1z0ARBK5uOPz2+tqdHOAGCjOK9XOwH4Ei75AAB6ol18SAUAQHhKfYGSv/9mzkEROajdosX0b/rtm8aaDwAAoZT5AiXfN3DNx5mYqJ1gqz6TJy/nkg+AUNImT16u3QDAXme3bdNOAL6ESz4wBmM+gFlyUl1HhA+pAAAIh1UdODcwLy3O2Es+kAOThqWvKOWiNAAAl2MdO9XWPzPFrDWfrTd/R0bv/X+1M+y0IXn06PIzW7dy0QfAX0mbPPlVEWnX7gAAgEs+AICeqoo1HwAAwlPqC5Q8Pib7kIgc0G7R4jB8zqdvevxB4aI0AACXVeYLlMwtzKoWkV3aLXZyxMVpJ9gq7f77f8QlHwB/yz1jxnPtjY3aGQBsFJOWpp0AXBaXfGAUp9PsN+wB03j7xH0ifEgFAEA4rM8aWwd4+8QZe8lHgkGJMfv3hoOs+QAAEJJVd7qtnyfZZdQlny0D75LbD/6ndoadNiYXFm44s3lzkXYIgMiQOn78OhGp1e4AAECESz4AgJ7Nx5oPAADhKfMFSn5gZX8iIj7tFi1GX/ERkX6s+QAAEFKZL1DyyO1ZNSKyXbvFTs74eO0EW7lnzFjKJR8Af+aePn1p+8mT2hkAbBTTu7d2AhCSUzsAsJuDw+EYdfL6xB2Six9SAQCAzrFqTrReeyEoYuppbQ9q/xloOzhpWPoK7QgAACKUVX+mzRsUs/76769/Q/vnbrfKFMv6QDsCgL7k0aPLxeCHYAAAkYclHwBAT3eAr5wAACA8Zb5AyWPfyD4iIlXaLdDBmg8AAKGV+QIlc27PNG7Nx5GQoJ1gK/esWT88XVExQbsDgK4+9977s7Zjx7QzANjIlZ2tnQB0iEs+MFKM06GdAMBGfEgFAEDYrNqTrf2zU13GXvI5dz4o8bFGj98e5KI0AAAhWa9vqXtpdkHmGO0QO23KuU3G1O7QzrCTL2XMmLLTmzZN1A4BoKpMOwAAgC/ikg8AwAR8SAUAQJjKfIGS79+RZfSaj+mPBlyTHn9AuCgNAEBHCkSkUjvCTo6YGO0EW2XMnv00l3wAc2U+/vj81poa7QwANorzerUTgCvikg+M5TD9HXvAMNe4+ZAKAIAwWcdOtfXPTDF3zaep7YIkuYxe8znERWkAAEKy3qise+Hh0Wat+Wz03Cpj63drZ9jpYOr48etOlZdP1Q4BYL+0yZOXazcAsNfZbdu0E4Ar4pIPAMAUfEgFAECYynyBkrmFWdUisku7RY3hDwdwURoAgCsybs3HmZCgnWArz9y587nkA5gnbfLkV0WkXbsDAIC/xSUfGM3JnA9glP4ZCfuED6kAAAiHVXe6rZ8n2WXsJZ+z5y5Ir3jWfLgoDQDAZVkrt9a9MMuwNZ/ylJtk/Onfa2fYqbp3UdHqkxs2FGuHALCPe8aM59obG7UzANgoJi1NOwHoFKPfqQQAGOfwpJvTV2hHAAAQTcp8gRIRGaXdocnpMPv0z4j/80VpAABweYXaAbaLjTXqZDzyyHztHzkA+6SMGVMmIrXaHQAAXA5LPjCekzEfwCjXZiRUCWs+AACEw/rXLcdfml1g1hPqX3SyuV16J8ZoZ2g6zJoPAAAhWW9urXv+oXzPGO0QO/0mYYB8q+WQdoadatMmTnyjsaxstnYIgO6XXlz8o7b6eu0MADZyeTzaCUCncckHAGCaI5NuTl9RupcPqQAACFOBiFRqR+gx++kAvvYUAIArssSw5Tuny6WdYKuMOXMWcskH6PmS8/PLRWS7dgcAAKFwyQcQ1nwA01zvSdglfEgFAEA4rDcq6154eLS5az4nms5LnySjf4VmzQcAgNCst7bVLzFtzec/YvrL3e1HtDPs5E+bMuXVxvXrv68dAqD7pN5998q2Wr6pCzCJKydHOwEIi1M7AAAABdX33Zy+XDsCAIAoVKAdoMnhMPt83fOXNR8AAHB55l2GjY016mTMmbNQ+0cOoNut0Q4AAKAjRj+GCHyR08GcD2CSAZmJO4U1HwAAwmGt3Fr3wvcMe0L9i/xn2sSdbNbXUvyNw3ztKQAAIVlvbatf8uAos14r/Xuwr9zj/Ew7w06n0ouLlwdWr56nHQKg63nmzl3cVlOjnQHARi6vVzsBCBuXfAAApqqZPNy9/L0qPx9SAQAQnkIR2awdocX0RwOuzUioEi5KAwDQkbEislE7wk5Ol1mXoD2zZy/gkg/QM6VNm7ZMuwGAvc5s2aKdAISNSz7AFzDmA5hlQGYCaz4AAITHWrWt/vmHDF7zqT/TJh6z13yOsOYDAEBI1tvb6xc9eJtn49C8JO0W23wqX5drGv6onWGnNvesWUv9b775jHYIgK7TZ8KEVSLSot0BAMCVcMkHAGCyminD3a+sZ80HAIBwWXLxoqyRTH824DrWfAAAuBLj1nw+zTDuos+zIsIlH6AHcc+cubi9sVE7A4CNYtLStBOAq8IlH+BvxDDnAxjlxqzE7cKHVAAAhMN6a1v9kgdHmbvmc+x0m2SnsObDmg8AAJdlvb2jftHLeddUiEi7doydAmvXaifYxhkXJ55HH322/rXXntduAfDVpVjWByJSrd0BAEBncMkHAGC6OtZ8AAC4KsY9of5XDH824DoPaz4AAHTA8h1tsoZ6k4x6rXTqsX+S1J//SDvDTktFhEs+QA+QNnXqK23Hj2tnALCRKytLOwG4alzyAS7D6dQuAGCnQTmJlVLFh1QAAITBent7/aIHb/NsHOJN0m5RU3+mTTtBE2s+AAB04Jc76hctm2Temo8jLk47wVaZjz8+v+4nP/mxdgeAq5ecn18uBn8dNQAg+nDJBwAAEf/UW9yvrNvDmg8AAGEyes3Hk+wS/9nz2hlqBmQm7hLWfAAACMXyHT07dqi3V7l2iJ1OPPyP0mfl/6WdYadXRIRLPkAUS7377pXn/X7tDAA2inW7tROAr4RLPkAIDsPn9wHTDMpJrBQ+pAIAIBzW24Y+oY6/qL7v5vTl77PmAwDAZb2zs+GZod5em0TEqPk/Z0KCdoKtsp988rFjL7/8c+0OAFdtjXYAAADh4JIPAAAX+afd4l62ljUfAADCYeQT6l+UnhQrgSZz13yuz0zcI1yUBgAgFMtXc3bMkNwko14rNTzwmGS8a9Sdl1eT8/PvO7Nt23jtEADh8cydu7itpkY7A4CNXF6vdgLwlXHJB+iAkzkfwCg35SZVyh4/H1IBABAGU59Qx1+w5gMAQAdW72x45sV7+/1ORFq0W+zkiIvTTrBVyrhxq7nkA0SftGnTlmk3ALDXmS1btBOAr8ypHQAAQAQ5Me1WN7/YAQAQHstXc3bMhWBQTD19EmPEIWLsGZCZuFMurvkAAIAvs/bVNFlBETHp1E2e3TU/veixKjk/36jFJiDa9ZkwYZUYdgETANAzsOQDXIGTMR/AKENykzav3c2aDwAA4TD1CXX8RQ1rPgAAhPburoanhnj7VYhhr5Uc8fHaCbZKLSpayZoPED3cM2cubm9s1M4AYKOYtDTtBKBLsOQDAMBfO3X/rRkvakcAABBlLF9Nk3UhKGLqSUmIEYdDjD03ZLHmAwBABy6u+QRFTDrH7pmh/XO32xrWfIDokGJZH4hItXYHAABXgyUfoBOcDuZ8AJMM8SZtXrNbWPMBACAMa3Y1PDXku/02i8hZ7RaoqJk83L38vSo/r58AALgMU18rORMTtRNs1Wfy5OWs+QCRL23q1Ffajh/XzgBgI1dWlnYC0GVY8gEA4MvOPjCCNR8AAMJk7a9pKrwQDIqpJynO7F+xB2QmsOYDAEBo1v6apsJgMCgmnZpv3qf9c7fbhuTRo1nzASLYpcUtfm8BAEQtlnyATnIy5gMYZag3qeLdXaz5AAAQjjW7G576l9y+W0XklHYLVLDmAwBAB9bsbnjq+dy+xq35OOLitBNslXb//T86s3Uraz5AhEoZN251W22tdgYAG7lycrQTgC5l9mOGAACE1lI8MmOpdgQAAFHG2v95U+GFoIipJ8HlFIdDjD03ZCVsF56KBQAgFGv/502W9usVu091wXe0f+5225hcWLhBOwJASKu0AwAA+CpY8gHC4HQw5wOYZJi316bVOxtY8wEAIAxrd/sXLPlOUqWInNBugYpa1nwAAAjtV7v9C577TtJmMWz50Bkfr51gK/eMGUvPbN5cpN0B4K+5Z85c1vrZZ9oZAGwU17evdgLQ5bjkAwBAaG3TR2YsfWdnAx9SAQDQedbvP28qGJiTaOzTy64Yh7S1B7Uz1HxhzYfXUAAAfJl1oLapcFB2klGvlf54y3j5+p5y7Qw7VaZY1genKyomaIcA+B/pxcUstwOGOfO732knAF2OSz5AmJx8yR1glJv79tr4Dms+AACEZe0e/4LF9+RtFxG/dgtU1E4Z7n5lPWs+AABc1trd/gX/fI95y4eOhATtBFu5Z836IZd8gMjRu6hotRi2ogYA6Jm45AMAQMfaH7zN89zbO+oXCRd9AADoLOvD2uaCgdmJH2iHaIl1OqT9gtFrPruENR8AAEKxPqw1b/nw8KBCue7DzdoZdvKljBlTdnrTponaIQBE0qdPX3Lez3MogEli3W7tBKBbsEkCAMCVbdQOAAAg2qzb439CRHg3xVy1U4a7X9GOAAAgUq3d418gBr5WcsTEGHUyZs9+WvtnDkAkubBwg4gc0u4AAKArsOQDXKV9NU3aCQDs4hB5cJTnube3s+YDAEAYrA9rmwtuNHjNx+FwaCeoujE7cbuw5gMAQChGLh8eGjBaBhzaqp1hp4Op48evO1VePlU7BDBZ2pQpy8/X12tnALBRrMejnQB0G5Z8AADoHNZ8AAAI0/oq/xMikqndATV1rPkAABCaqcuHzoQEo45n7tz52j9zwGTJ+fnlIlKu3QEAQFdhyQf4CpxmP5gLGOehfM/it7bVLxGeRgcAoLOsj441jxqQlWDUE+p/K8bgRZ+BrPkAANARI9d8DvYdLgM/q9LOsFN176Ki1Sc3bCjWDgFMlFxY+Ou2o0e1MwDYyJWXp50AdCuWfAAA6LwK7QAAAKLNpTWfHO0OqGHNBwCADhi7fBgba9TJeOQR1nwAPT/VDgAAoCux5AN8RU6Dn8oFTDRrdOazb26te154Gh0AgM6yPj7eMmpAZkKZdoiW88GguGLM/b1hUE5ipVSx5gMAQAjWwWPNo24wbPnw99mD5aZjB7Qz7FSbNnHiG41lZbO1QwCTuGfOXNZWV6edAcBGrkzz7k7DPFzyAQAgPJu1AwAAiDbvVfnnPfUt704RqdFugQr/1Fvcr6zb4+eSDwAAl7G+yv/EM9/27hKRWu0WOzldLu0EW2XMmbOQSz6AvdKLi5dqNwCw1+nf/lY7Aeh2fF0X0AUcDg6HY9J5uCDzaeGruwAACIf18fHmkReCIqaec+eD2n8GqgZmJ1YKr58AAAjF+vh4y4igiJh09rlv6JqfXvTwp02Z8qp2BGCK3kVFq0XklHYHAABdjSUfAADCV6kdAABAtHl/b2Dewru8e0SkWrsFKljzAQCgA+ur/E88beCaj8Sa9RFFxpw5CxvXr/++dgdggvTp05ec9/u1MwDYKNbt1k4AbMGSD9BFnBwOx6gzpyBzofA0OgAA4bAO1TWPuBAMiqmnue2C+iKh5hmUw5oPAAAdsD4+3jIqGBQx6fhSr9X+udvtVHpx8XLtCKCnSy4s3CAih7Q7AADoDmZdkwcAoOtsnzgsfUWZL8DT6AAAdFLp3kDJk+Nzq0TkiHYLVPin3eJetpY1HwAALuu9Kv+8p77l3SkiNdotdnK6XNoJtvLMnr0gsHr1PO0OoCdLmzJl+fn6eu0MADaK9Xi0EwDbcMkH6EJOp0M7AYCNMlNc1XLxaXQ+qAIAoHOsw/Utw7+ekWDsJZ8z5y5ISnyMdoaaQTlJlSJ+Xj8BAHB51sfHm0den5lo1CWf3Qn95NaWau0MO7W5Z81a6n/zzWe0Q4CeKDk/v1xEyrU7AADoLlzyAQDg6u1izQcAgPCU7g2UPHFn7j4ROazdAhUnWPMBACC09/cG5i28y7tHRIy69WKgZ0WESz5AN0guLPx129Gj2hkAbOTKy9NOAGzFJR+gizkY8wGMkpXKmg8AAGGy/ljfMrR/Rryxl3xOtZyX3onm/jp+U25SpexhzQcAgBCsP9Q133J9ZqJRl3x2J/ST/r/4sXaGbZxxceJ59NFn61977XntFqAH+ql2AAAA3cncdxUBAOgarPkAABCmUl+g5B/H5bDmY64T0251L1u7mzUfAAAuhzUfYywVES75AF0o/YEHlrfWGPWNh4Dx4rxe7QTAdlzyAbqBUzsAgK1yUl1HhDUfAADCYR1pODf0mnRz13waz56X9F7m/ko+OCdp81phzQcAgBCsQ3XNI67LSDDqks8nM56Q69b+RDvDVpmPPz6/7ic/MWfCCOhm7unTuTgHGOb0pk3aCYDtuIsAAMBXVzVxWPoK7QgAAKJJqS9QIiIDtDug5tS0W93LtCMAAIhUpXsDJSLSX7sD3e4V7QCgp0gdP36diPi1OwAA6G7mPjYIdDOn06GdAMBG3j5xnwhrPgAAhMP6NHBucN/0+EPaIVoazp4XT7K5v5YPyU3avHY3az4AAIRgHW5oGX5tRsIR7RA7/WHa43LDv/2rdoatsp988rFjL7/8c+0OINq5p09fer6hQTsDgI1iMzK0EwAVLPkAANA1fKz5AAAQnktrPgO1O6Dm1N+x5gMAQEis+Rjj1eT8/HLtCCCaJY8eXS4iPu0OAADsYO4jg4ANGPMBzNI3Le6QsOYDAEA4rM8C5wZ6+8Qd1A7RcvxUm2SnurQz1AzJTar4FWs+AACEYn1S3zK8v2FrPgcnPCKDfvOWdoatUsaNW31m27bx2h1AtOpz770/azt2TDsDgI1c2dnaCYAalnwAAOg6Byax5gMAQFgurfkM1u6AmrP335rxonYEAACR6tJrpeu0O9DtVrHmA3wlZdoBAADYhSUfoJs5Hcz5ACbplx5/UFjzAQAgHNbRE60DvH3iDmiHaKk91Sa5veO0M9QM8SZtXrOb108AAIRgHWloGfo1d/xh7RA7/f6umTK44lfaGbZKLSpayZoPEL7Mxx+f31pTo50BwEZxXq92AqCKSz4AAHStg5OGpa8o9QX4kAoAgE4q8wVKfmBlfyIiPu0WqDh7/4iMF9fsauD1EwAAl1HqC5T8w9icAyJySLsF3WpNcn7+w1z0AcKTNnnycu0GAPY6u22bdgKgiks+gA2cjPkARvmaO/6AsOYDAEA4rJoTrdfmpLqMveRztPGc5KXFa2eoGZKbtHkNr58AAAjF+pP/3OBr0uONuuSz/xt/J8N2/pt2hq36TJ68nEs+QOelTZ78qoi0a3cAAGAnLvkAAND1DrHmAwBAeMp8gZLH7sg6IiJV2i1QwZoPAAAdKPUFSuZ9kzUfA2xIHj26/MzWrVz0ATrBPWPGc+2NjdoZAGwUk5amnQCo45IPYBOHgzkfwCT9MxL2CU+jAwAQDqv2VFv/zBSXsZd8Pg2ck2vSWfMRXj8BAHA51qeBc4P7GrbmUzXyu3KL739rZ9gq7f77f8QlH+DKUsePXycitdodAADYjUs+AAB0j8OTbk5fUbqXNR8AADqrzBcomVuYVS0iu7RboII1HwAAOlDqC5SUfDPnoIgc1G5Bt9qYXFi44czmzUXaIUAkc0+fvrT95EntDAA2iundWzsBiAhc8gFsFMOYD2CU6zISqoSn0QEACIdVd7qtnyfZZewlnz/5z0n/DHPXfIZ6kyrW7OL1EwAAIVifBc4NzEuLM+qSz+6h35KRH2/SzrCVe8aMpVzyAUJLHj26XER82h0AAGjgkg8AAN3nCGs+AACEp8wXKHnk9qwaEdmu3QIVLQ+MyHjxXdZ8AAC4rFJfoOTxMdmHROSAdgu6VWWKZX1wuqJignYIEIn63Hvvz9qOHdPOAGAjV3a2dgIQMbjkA9jM6WTOBzDJgMzEXcKaDwAA4bDqz7R5M3qZ++vqH+tb5FpPgnaGmqHepIp3WfMBACAU67PG1gHePnFGXfLZPmCM5Fdv086wlXvWrB9yyQcIqUw7AAAALea+awoAgD2q77s5ffn7rPkAANBpZb5AyZyCTNZ8zMWaDwAAHSjzBUp+YGV/InxVTU/nSxkzpuz0pk0TtUOASJL5+OPzW2tqtDMA2CjO69VOACIKl3wABWz5AGYZkJm4U1jzAQAgHNbrlXUvPTw6c4x2iJY/1LXIgCxz13yG5SVtZM0HAICQrJoTrdfm9o4z6pLP1r75UvD5Tu0MW2XMnv00l3yAv5Y2efJy7QYA9jq7zaw1P+BKnNoBAAAYoGbycPdy7QgAAKJQgXYA1LQVj8xYqh0BAECkKvMFSkRkmHYHut3B1PHj12lHAJEibfLkV0WkXbsDAABNLPkASpxcsQOMckNWwnZhzQcAgHBYK7fWvTDL4DWfj4+3yI1ZidoZaoZ5e21avbOB108AAFye9fnJ1mtzUl1GrflsyRkhdzQe0M6wlWfu3PmnysunancAkcA9Y8Zz7Y2N2hkAbBSTlqadAEQcrhkAAGCP2inD3a9oRwAAEIUKtQOgpm06az4AAIR0ac1nuHYHul1176Ki1doRgLaUMWPKRKRWuwMAAG0s+QCKnA6HdgIAG92YnciaDwAA4bHe3Fr3/EP5njHaIVo+PNYkN+UkaWeoGZbXa+M7rPkAABCKVXuqrX9WqqtKO8ROFWmDxTr9kXaGrTIeeWT+yQ0birU7AE3pxcU/aquv184AYCOXx6OdAEQklnwAALBPHWs+AABcFS54mKudNR8AAEK7tOYzQrsD3a42beLEN7QjAC3J+fnlIrJduwMAgEjAkg+gzMmYD2CUQTmJlVLFmg8AAGGw3tpWv2TmKHPXfA583iSDc1nzEV4/AQBwOdbxU239MlNcu7RD7LQp+UYZe+4T7QxbZcyZs7CxrGy2dgegIfXuu1e21fJNXYBJXDk52glAxGLJBwAAe/mn3sKaDwAAV4ELHuZqn3Gb5zntCAAAIhVrPsbwp02Z8qp2BKBkjXYAAACRgiUfIAI4Hcz5ACa5KSfpd+vEz9PoAAB0nvWL7fVLHrzNM2ZonrmLNiYblpdU8csdrCECABCCVXe6rZ8n2aw1n/+Ku1bGXfhUO8NWGXPmLGxcv/772h2AnTxz5y5uq6nRzgBgI5fXq50ARDQu+QAAYL8T025xL1u7x8+HVAAAhGesiGzUjoCK9gdv8zz39o76RcJFHwAAvqTMFyh55PasGhHZrt2CbnUqvbh4eWD16nnaIYBd0qZNW6bdAMBeZ7Zs0U4AIhqXfIAI4WTMBzDK4NykzWv3sOYDAEAYrLd31C96Oe+aChFp146Bio0iskg7AgCACGXVn2nzZvQy6y3/3zr6yV2xtdoZtvLMnr2ASz4wRZ8JE1aJSIt2BwAAkcSsV/wAAESOU9NudS9bu5s1HwAAwmDtPXp27DBvr3LtEE37a5q0E9Sw5gMAQGhlvkDJnIJM1nx6vjb3rFlL/W+++Yx2CNDd3DNnLm5vbNTOAGCjmLQ07QQg4jm1AwD8D6eDw+GYdIbmJlWISIX2f/cAABBN3tnR8IyIxGh3QA1f1wYAQGjW65V1LwVFxKTzm/M5XfPTiy7PagcA3S3Fsj4QkWrtDgAAIg1LPgAA6Dl7/4iMF9fsauBJdAAAOs/ae/Ts2CG5Scau+QzKSZQPjzVrZ6h5cJTnube3s+YDAEAHCkSkUjvCToG1a7UTbOWMixPPo48+W//aa89rtwDdJW3q1Ffajh/XzgBgI1dWlnYCEBVY8gEijMPh4HA4Bp0huUmbhTUfAADCsnpnwzMikqDdATWs+QAAEJr1RmXdC8GgiElnx6S/1/65a1iqHQB0l+T8/HLhPVMAAC6LJR8AAHSdfWBExovvsuYDAEA4rH01Tdbg3KTfaIdouTErUT4+bu6az8xRnsW/2F6/RFjzAQAgFOPWfBxxcdoJtst8/PH5dT/5yY+1O4Culnr33SvP+/3aGQBsFOt2aycAUYMlHyACOR0cDsekM9SbVCE8mQIAQFje3dXwlIj00u6AGl47AQAQmrVya90LQREx6Wy757Gu+elFl1e0A4BuskY7AACASMWSDwAA+lqKR2YsXb2TNR8AAMJg7f+8qXBwTqKxaz4DMhPkD/Ut2hlqHsr3LH5rG2s+AAB0oFBENmtH2MmZYN43umY/+eRjx15++efaHUBX8cydu7itpkY7A4CNXF6vdgIQVbjkA0SoGKdDOwGAjW7O67Vx9c6GCuFDKgAAOm3Nroannp/Qd7OInNVugQrWfAAACM16c2vd8w/le8Zoh9hp89jvSeHGVdoZdns1OT//vjPbto3XDgG6Qtq0acu0GwDY68yWLdoJQFTh67oAAIgM7dNvy1iqHQEAQJSx9n/eZF0Iiph6rs0w72n1L3oo37NYuOwDAEBHjHuYyBEXZ9xJGTdutfbPHegKfSZMWCUi5s6VAgDQCSz5ABHMwZgPYJSb83ptfGcHaz4AAITjV7v9C577TtJmETml3QIVXPABACA0661t9UtmjjJrzee/by+Wb2wx7s7LquT8/GLWfBDt3DNnLm5vbNTOAGCjmLQ07QQg6nDJBwCAyNH+4G2e597eUb9IuOgDAEBnWQdqmwoHZSdt0A7R0t+dIH/ym/uw6/fyPc+u2lb/vPD6CQCAUCwx7GKsIz5eO8F2qUVFK7nkg2iWYlkfiEi1dgcAAJGOSz4AAESWjSKySDsCAIBosna3f8E/35NUKSIntFugYrN2AAAAEcz6xfb6JQ8atuazacRkGbPrPe0Mu61Jzs9/mIs+iFZpU6e+0nb8uHYGABu5srK0E4CoxCUfIArsr2nSTgBgE4dDZOYoz+JfbK9fIjyNDgBAZ1kf1jYV3JidaOyaT7/0eKkOnNPOUMOaDwAAVzRWLj5YZAxnYqJ2gu36TJ68nEs+iEbJ+fnlYtjiGAAAV4tLPgAARB5+oQUAIExr9/gXLCrK2y4ifu0WqGDNBwCA0Ky3t9cvevA2z8aheUnaLbZp8E6RjP9cr51htw3Jo0eXn9m6lYs+iCop48atbqut1c4AYCNXTo52AhC1uOQDRAmHQ7sAgJ0eyvcsfmsbaz4AAITB+rC2uWBgduIH2iFa+qbFy9ETrdoZamaNznz2za11rPkAABCacWs+DXdNEc+mf9POsFXa/ff/iEs+iEKrtAMAAIgWXPIBACAyseYDAECY1lf5n/jh3XnbRaROuwUqWPMBACA06+0d9YtezrumQkTatWPQrTYmFxZuOLN5c5F2CNAZ7pkzl7V+9pl2BgAbxfXtq50ARDUu+QBRxMmcD2AUnkYHACBs1sFjzaNuyEowds0nt7dLak+2aWeoeXh05tMrt9a9ILx+AgDgcizf0SZrqDfJqDWfOuu7kr3tN9oZtnLPmLGUSz6IFunFxUu1GwDY68zvfqedAEQ1p3YAAAAIiafRAQAI0/oq/xMiwhe7m6tSOwAAgEj2yx31i0QkRrsD3a4yxbKMvfiO6NG7qGi1iJzS7gAAIJqw5ANEGSdjPoBRZhdkPv1GJU+jAwAQBuuj4y2jBmQmlGmHaMlKdcnxU6z5CK+fAAC4HMt39OzYod5e5dohdqod9S3J9Zn1zejuWbN+eLqiYoJ2B9CR9OnTl5z3+7UzANgo1u3WTgCiHks+AABENp5GBwAgTO9V+eeJiFe7A2p4/QQAQAfe2dnwjIi4tDvQ7XwpY8aUaUcAoSQXFm4QkUPaHQAARBuWfIAo5GDNBzDKnNszF76+pe4l4Wl0AAA6y/r4ePPI6zMTa7RDtHhSXNJwxtw1H9YQAQDokOWrOTtmSG6SUWs+R4d+Q/r+fot2hq0yZs9++vSmTRO1O4DLSZsyZfn5+nrtDAA2ivV4tBOAHoElHwAAIt/2icPSV2hHAAAQTd7fG5gnIv20O6CGNR8AADqw+uKaT4J2B7rdwdTx49dpRwB/Kzk/v1xEjLpoCABAV2HJB4hSTuZ8AKNkpriqRaRCeBodAIDOsv5Q13zLtZ6Eau0QLem9YqXx7HntDDVzCjIXvl7JGiIAACFY+2qarCHepN9oh9ip+qbb5Wuf7NbOsJVn7tz5p8rLp2p3AF+UXFj467ajR7UzANjIlZennQD0GCz5AAAQHXax5gMAQHgurfn01+6Amu3aAQAARLJ3dzU8Jaz5mKC6d1HRau0I4G/8VDsAAIBoxZIPEMWcjPkARslOdR0R1nwAAAiHdbi+Zfi1GQlHtEO09EmKlRPNBq/53J658PUtrPkAABDCxTWfXLPWfI58/VbpX+3TzrBVxiOPzD+5YUOxdgcgIuKeOXNZW12ddgYAG7kyM7UTgB6FSz4AAESPqonD0leU+QJ8SAUAQCeV7g2UzL8zt0pEjL3oY7jtvH4CACC0Nbsanhry3X6bReSsdgu6VW3axIlvNJaVzdYOAdKLi5dqNwCw1+nf/lY7AehRuOQDRDmHgzkfwCQ5veNY8wEAIDzWJw0tw/u7zV3zSU2IldMt7doZajzJrhrh9RMAAKFY+2uaCm/KTTRqzeeTvkPl+mMHtTNslTFnzkIu+UDbpa+OO6XdAQBANOOSDwAA0YU1HwAAwlS6N1Dyj+Ny94nIYe0WqGDNBwCADqzZ3fDUv+T23Sp88N7T+dOmTHm1cf3672uHwFzp06cvOe/3a2cAsFGs262dAPQ4XPIBegAnYz6AUbx94j4RnkYHACAc1pGGlqHXuOONveTTK94pTa0XtDPUZKa4qoXXTwAAhGLt/7ypcHBO0gbtEDsdyhooA/x/0M6wVcacOQu55AMtyYWFG0TkkHYHAADRjks+AABEHx9PowMAEJ5SX6Bk3ticA8KbyqbaxesnAABCW7vbv2Dwd5I2C2s+Pd2p9OLi5YHVq+dph8A8aVOmLD9fX6+dAcBGsR6PdgLQI3HJB+ghWPMBzNI3Le6Q8DQ6AADhsD71nxvcLz3e2Es+iS6nNLex5iO8fgIA4HKsA7VNhYOyzVrz+Sj9ehl0+k/aGbbyzJ69gEs+sFtyfn65iJRrdwAA0BNwyQcAgOh0YNKw9BWlPI0OAECnlfoCJX//zZyDInJQuwUqWPMBAKADa3f7F/zzPUmVInJCuwXdqs09a9ZS/5tvPqMdAnMkFxb+uu3oUe0MADZy5eVpJwA9Fpd8gB7E6WDOBzBJv/T4g8LT6AAAhMOqDpwbmJcWZ+wln/hYh7S2B7Uz1GSlsuYDAEAHrA9rmwoG5iQatebz+5Rr5KbTn2pn2O1ZEeGSD+z0U+0AAAB6Ci75AAAQvQ6y5gMAQHhKfYGSx8dkHxKRA9otUMGaDwAAHVi7x79g8T1520XEr91ip8DatdoJtnLGxYnn0UefrX/ttee1W9DzpT/wwPLWmhrtDAA2ivN6tROAHo1LPkAPE+PULgBgp/4Z8fuEp9EBAAiH9Vlj6wBvnzhjL/nEOh3SfsHcNZ/sVNcR4fUTAAChWB/WNhcMzE78QDvETp8//KTkrnxZO8NuS0WESz7odu7p0/nPGWCY05s2aScAPRrXAQAAiG6HJw1LX6EdAQBANCnzBUpEZJh2B9RUTeT1EwAAIa3b439CRNzaHXZzxMUZdzIff3y+9s8dPVvq+PHrxLBlMAAAuhtLPkAP5HA4tBMA2OjrngTWfAAACI9Vc6L12pxUl087RIvpvzHksOYDAEBHjFzzOTr97yXvnf+fdobdXhGRH2tHoOdyT5++9HxDg3YGABvFZmRoJwA9Hks+AABEv8OTbuZpdAAAwnFpzWe4dgfUsOYDAEAH1lf5nxCRTO0OuzkTEow72U8++Zj2zx09U/Lo0eUiYuyDFQAAdBeWfIAeiht8gFmuy0ioEp5GBwAgHFbtqbb+WamuKu0QTU6DV0Bzesex5gMAQGjWwWPNo27ISjBqzedP982Vr73//2hn2O3V5Pz8+85s2zZeOwQ9S5977/1Z27Fj2hkAbOTKztZOAIzAPQAAAHqGI6z5AAAQnktrPiO0O6CGNR8AADpwac0nR7vDbo64OONOyrhxq7V/7uiRyrQDAADoiVjyAXowp9Pcp3IBEw3ITNwlPI0OAEA4rOOn2vplprh2aYdoaQ8GxRVj7u8N3j5xnwivnwAACMX6+HjLiOszzVrz+eSe78m1/75KO8Nuq5Lz84tZ80FXyXz88fmtNTXaGQBsFOf1aicAxuCSDwAAPUf1fTenL39/b4APqQAA6KQyX6BkbmFWtYgYe9HHcL6Jw9JXlPl4/QQAwOWsr/I/8dS3vHtExKhP6x3x8doJtkstKlrJJR90lbTJk5drNwCw19lt27QTAGNwyQfo4RjzAcxyQ1biTuFpdAAAwmHVnW7rl5Eca+wln3PngxIfa+63ebPmAwBAh6xDdS0jB2QmGHXJ5/CdD8h1v31XO8Nua5Lz8x/mog++qrTJk18VkXbtDgAAeiou+QAA0LPUTB7uXv5elZ8PqQAA6KQyX6Bkzu2ZNSKyXbsFKljzAQCgA+9V+ec99S3vTjFszceZmKidYLs+kycv55IPvir3jBnPtTc2amcAsFFMWpp2AmAUcx/VAwzicHA4HJPODVkJ2+Xi0+gAAKBzrNe31L0UDIqYelraLmj/Gaj6wpoPAAD4Muvj480jLwRFTDofFUzU/rlr2JA8enS5dgSiV+r48etEpFa7AwCAnowlHwAAep7aKcPdr6xnzQcAgHAViEildgRUsOYDAEAH3t8bmLfwLu8eEanWbrGTIy5OO8F2afff/6MzW7ey5oOr4p4+fWn7yZPaGQBsFNO7t3YCYBwu+QCGiHE4tBMA2GhgduKf13z4oAoAgM6x3qise2HW6Mwx2iFamlovSK84cwd/8/rEHRJePwEAEIr1h7rmW67zJBh1yefDW++WQbv/QzvDbhuTCws3nNm8uUg7BNHl0gqUT7sDAICejks+AAD0THWs+QAAcFUKRWSzdgRUHGDNBwCA0N7fG5i3YHyucWs+zvh47QTbuWfMWMolH4Srz733/qzt2DHtDAA2cmVnaycARuKSD2AQxnwAswzKSayUKp5GBwAgDNabW+uefyjfM0Y7RMvpc+2SmhCjnaGmbxprPgAAdMD6Q33LiOsyzFrz2X/TWBny+43aGXarTLGsD05XVEzQDkFUKdMOAADABFzyAQCg5/JPvcX9yro9rPkAABAmSy5e9IB5Dkwalr6ilDUfAAAuq3RvoOTJO3OrROSIdoudHAkJ2gm2c8+a9UMu+aCzMh9/fH5rTY12BgAbxXm92gmAsbjkAxjGyZwPYJSbcpJ+t078PI0OAEDnWW9tq18yc5S5az4nm9ulT5K5bxf0TY8/KKz5AAAQinW4oWX41zMSjLrks/faArn5k0rtDLv5UsaMKTu9adNE7RBEvrTJk5drNwCw19lt27QTAGM5tQMAAEC3OjHtVvcy7QgAAKIQFzzMdXDSsPQV2hEAAESq0r2BEhG5TrvDbo6YGONOxuzZT2v/3BH50iZPflVE2rU7AAAwhbmP5gEGczLmAxhlcE7S5rWs+QAAEA7rF9vrlzx4m7lrPo1nz0t6L3PfMujHmg8AAB2x/ljfMrR/RsJh7RA77blmlNzy6XbtDLsdTB0/ft2p8vKp2iGIXO4ZM55rb2zUzgBgo5i0NO0EwGjmvmMHAIA5Tv3dre5lv9rt50MqAADCM1ZENmpHQMXBScPSV5T6Arx+AgDgMkp9gZJ/HJe7T0SMuujjTEjQTrCdZ+7c+VzyQSgpY8aUiUitdgcAACbhkg9gKNZ8ALMMyU2q+NVu1nwAAAiD9faO+kUzbvNsHOpN0m5R8/mJVu0ENdekxx8Q1nwAAAjFOtLQMvQad7xRl3x2ZA6V2+r2aWfYrbp3UdHqkxs2FGuHIPKkFxf/qK2+XjsDgI1cHo92AmA8p3YAAACwxdn7R2S8qB0BAEAUGqsdoCm3T5x2gqZDk4alr9COAAAgUpX6AiUiMkC7w3axscadjEcema/9Y0fkSc7PLxcR477DDgAAbSz5AAZzMucDGGWoN6lizS6eRgcAIAzWL3fUL1o26ZoKEWnXjlFj8K8N17hZ8wEAoAPWp/5zg/ulxx/SDrHT9rRBMqrxQ+0Mu9WmTZz4RmNZ2WztEESO1LvvXtlWyzd1ASZx5eRoJwAQlnwAADBJywOs+QAAEC7Ld/Ts2AvBoJh6slNd2n8GmljzAQCgA5fWfAZqd9jN6XIZdzLmzFmo/XNHxFmjHQAAgIlY8gEMx5gPYJZheUkb32XNBwCAsLyzs+GZH3n7bRKRNu0WLSb/3tA/I36fsOYDAEAoVnXg3MC+6fEHtUPsVJl8vRSc+YN2ht38aVOmvNq4fv33tUOgzzN37uK2mhrtDAA2cnm92gkALuGSDwAAZmmbPjJj6Ts7G/iQCgCAzrN8R5vGDvEm/UY7REtGsksazhh7x+nwpGHpK0p9AV4/AQBwGaW+QEnJN3MOiohRF30k1ryPVzLmzFnIJR+IiKRNm7ZMuwGAvc5s2aKdAOAS816FAvgSp8Pgx3IBAw3L67XxnZ0NPI0OAEAY3t3V8NQQb78KEWnRbtFj7u8N/TMSWPMBACA067PAuYHePnFGXfLZHPc1KWz9k3aG3U6lFxcvD6xePU87BHr6TJiwSoz+vQgAAF1c8gEAwDztM27zPPfLHfWLhA+qAADoLGtfTZM1JNfcNR93r1jxnz2vnaGFNR8AADpQ6guU/C8r+5CIHNBusZPT5dJOsJ1n9uwFXPIxm3vmzMXtjY3aGQBsFJOWpp0A4Auc2gEAAEDFRu0AAACizZpdDU+JSC/tDk0Oh7nn656/rPkAAIAvs46eaB0QFBGTToXD2zU/vejS5p41a6l2BHSkWNYHIlKt3QEAgMlY8gHwF/trmrQTANjEISIP3uZ57m3WfAAACIe1v6ap8KbcRGPXfPokxsiJ5nbtDC2HJ92cvqJ0L2s+AABcTpkvUPIDK/sTEfFpt9ipwuEVK1ijnWG3Z0XkGe0I2C9t6tRX2o4f184AYCNXVpZ2AoC/wSUfAADMtVFEFmlHAAAQTdbsbnjqX3L7bhWRU9otWhzaAYquzUiokotrPlz0AQDgy6yaE63X5vSOM+qSj4hIYO1a7QRbOePixPPoo8/Wv/ba89otsE9yfn65sGwJAIA6LvkA+CsOk9+xBww0c5Rn8S+21y8RPqgCAKCzrP2fNxXelJO0QTtES0pCjJxuMXbN5whrPgAAhFbmC5Q89o3sIyJSpd1iJ9+0f5Bha/+/2hl2WyoiXPIxSOrdd6887/drZwCwUazbrZ0A4DK45AMAgNl4+gYAgDCt3e1fsOQ7SZUickK7RYvJzwZcx5oPAAAdsWpPtvbPSXUZdclHRMQRH6+dYLvMkpL5dStW/Fi7A7ZZox0AAAC45APgMpwmv2MPGOh7+Z5nV22rf174oAoAgM6yfv95U8HAnERj13yS4p3SdO6CdoYW1nwAAOhAmS9Q8tgdWcat+ez97mNy87/9XDvDbq+ICJd8DOCZO3dxW02NdgYAG7m8Xu0EACFwyQcAAGzWDgAAINqs3eNfsPievO0iYu5evcEPB1znYc0HAIAOWLWn2vpnGbjm4zRwzSf7yScfO/byy8bdbjJN2rRpy7QbANjrzJYt2gkAQnBqBwCITE6Hg8PhGHQeHp35tPDVXQAAhMP6sLa5IBgUMfUkuox+S+HIpJvTV2hHAAAQqcp8gRIRGaHdYbdd33pYO0HDq8n5+eXaEeg+fSZMWCUiLdodAADgIpZ8AACAiEildgAAANFm3R7/E4uK8irF4DUfp8PcOZ8BmYm7hDUfAABCsY6fauuXmeLapR1iN0dcnHaC7VLGjVt9Ztu28dod6B7umTMXtzc2amcAsFFMWpp2AoAOGP3YHYCOORwcDsekM7uANR8AAMJkfVjbXHDhgoipx+V0aP8ZaKpmzQcAgNBMXfPZMWaGdoKGVaz59EwplvWBiFRrdwAAgP/Bkg8AAPgz1nwAAAjT+ir/E89+O2+7iNRpt8B+rPkAANAhq+50Wz9PsoFrPvHx2gm2Sy0qWsmaT8+TNnXqK23Hj2tnALCRKytLOwHAFbDkA6BD2ssiHA7H3jPn9syFwpoPAADhsD463jyqPRgUU4/ZYz5Sfd/N6cu1IwAAiFSX1nxGaXfYbVv+VO0EDWtY8+lZLv158j4hAAARhiUfAADwRdsnDktfUeYL8DQ6AACdtL7K/8RT3/LuEZEa7RbY7/rMxD3Cmg8AAKFY9WfavBm9zPsowpmYqJ1guz6TJy9nzafnSBk3bnVbba12BgAbuXJytBMAdIJ5r6wBhM3pMPvRXMA0mSmuauGDKgAAwmEdqmsZeb0nwdhLPg4RCWpH6Km+7+b05e/v5ZI0AACXU+YLlMwpyKwRke3aLXbaMvQeuX3fv2tn2G1D8ujR5We2buWiT8+wSjsAAAB8GZd8AADA39rFmg8AAOF5r8o/75/u8u4Ug9d8TH40YEBm4k7hkjQAAKFYr1fWvTS7IHOMdojdHHFx2gm2S7v//h9xySf6uWfOXNb62WfaGQBsFNe3r3YCgE7ikg+ATnGa/I49YKDsVNcR4YMqAADCYR2qax55fWaisZd8RIy+6FPDmg8AAFdUICKV2hF2+t2N4+WOj8q1M+y2MbmwcMOZzZuLtENw9dKLi5dqNwCw15nf/U47AUAncckHAABcThVrPgAAhOf9vYF5C+/y7hGRau0WLSZ/0+8NWaz5AADQAeuNyroXHh5t3pqPMz5eO8F27hkzlnLJJ3r1LipaLSKntDsAAMDlcckHQKc5TH7HHjBQTu841nwAAAiPdaiuecR1GQnGXvK5ICKxMcb+3lAzebh7+XtVfl47AQAQmnFrPpu+9g0Z86f/1s6wW2WKZX1wuqJignYIwpc+ffqS836/dgYAG8W63doJAMLAJR8AABAKaz4AAISpdG+g5Mk7c6tE5Ih2C+w3IDOBNR8AAEKzVm6te+F7+Z4x2iF2cyQkaCfYzj1r1g+55BN9kgsLN4jIIe0OAAAQGpd8AITF3IdyATPl9Yk7JHxQBQBAOKzDDS3D+7sTjL3k034+KPGxxv7iwJoPAABXVigim7Uj7PRfWSNl3PGd2hl286WMGVN2etOmidoh6Ly0KVOWn6+v184AYKNYj0c7AUCYnNoBAAAgoh2YOCx9hXYEAADRpHRvoERErtPu0ORwmHtuyErYLhcvSQMAgC+zVm2rfz4oIqYdR0yMcSdj9uynu+Q/NbBFcn5+uYiUa3cAAICOseQDIGxOp7FP5QJG6pcef1BY8wEAIBzWkYaWoV9zxx/WDtHS3BqUxDhjnyuqnTLc/cp61nwAAOiIJYZdii3PuEXGN+zRzrDbwdTx49edKi+fqh2CK0suLPx129Gj2hkAbOTKy9NOAHAVuOQDAACu5OCkYekrSn0BPqgCAKCTSn2Bkn8Ym3NARA5pt2gx+dGAG7ISdgmXpAEACMV6a1v9kpmjPGO0Q+zmTEjQTrCdZ+7c+VzyiRo/1Q4AAABXxiUfAFfF2GdyAUNdkx5/QPigCgCAcFh/8p8b3C893thLPmfOXZDkeGN/c2DNBwCAKzNuzed/9xok3z77oXaG3ap7FxWtPrlhQ7F2CEJzz5y5rK2uTjsDgI1cmZnaCQCuEpd8AABAZxxizQcAgPCU+gIlf//NnIMiclC7RYvDYe6ez43ZiduFS9IAAIRi/WJ7/ZIHDVzzkVjzPpbJeOSR+VzyiWzpxcVLtRsA2Ov0b3+rnQDgKpn3ahJAl3Ea+1AuYKb+GfH7hA+qAAAIh1UdODcwLy3O2Es+J5vPS+9EY996qGPNBwCAKxorIhu1I+z0H/ED5O5zxo091qZNnPhGY1nZbO0QfFnvoqLVInJKuwMAAHSOse+0AQCAsB1mzQcAgPCU+gIlj4/JPiQiB7RbtJi75SMykDUfAAA6Yr29vX7Rg7d5Ng7NS9JusZXzM5d2gu0y5sxZyCWfyJQ+ffqS836/dgYAG8W63doJAL4CLvkA+EpMnt8HTPR1TwJrPgAAhMf6rLF1gLdPnLGXfAJN5yU9ydi3H1jzAQDgyoxb8/ms703S97Pfa2fYzZ82ZcqrjevXf187BP8jubBwg4gYNy0FAEA0M/ZdNgAAcFUOT7o5fUXpXtZ8AADorDJfoOQHVvYnIuLTbtFi8rMBg3ISK6WKS9IAAIRgvb2jftHLeddUiEi7doytYs37eCZjzpyFXPKJLGlTpiw/X1+vnQHARrEej3YCgK/IvFeRALqc0+A37AETXedJqBLWfAAACIdVc6L12pzeccZe8qk/c148yca+BeGfeov7lXV7WPMBACAEa+/Rs2OHeXuVa4fYqTr7Bul37GPtDLudSi8uXh5YvXqedghEkvPzy0XEqP+9AwCgJzD2HTYAAHDVjtx3c/ry91nzAQCg08p8gZLHvpF9RESqtFtgv4HZiZXCJWkAAEJ6Z0fDM8Mm9doohq35OF0u7QTbeWbPXsAln8iQXFj467ajR7UzANjIlZennQCgC3DJB0CXcJq8vw8Y6PrMxD3CB1UAAITDqj3Z2j871WXsJZ+6022SmWLeB1mXsOYDAEDHLN/Rs2OHGrbmcyT969I/8EftDLu1uWfNWup/881ntEMgP9UOAAAA4eOSDwAAuBrVrPkAABCeMl+g5Pt3ZBm95mPyswGDcljzAQCgI+/sbHhmqLfXJhFp026xk6EXfZ4VES75KEp/4IHlrTU12hkAbBTn9WonAOgiXPIB0GWcBr9hD5johqzEncIHVQAAhMM6dqqtf2aKuWs+tSfbJKe3uWs+025xL1vLmg8AAKFYe4+eHTvUm/Qb7RC7Bdau1U6wlTMuTjyPPvps/WuvPa/dYir39On87AHDnN60STsBQBdxagcAAICoVTN5uHu5dgQAANGkzBcoEZER2h2aHAb/NSgn6c9rPgAA4DLe3dXwlIgkaHfYrfHRhdoJGpZqB5gqdfz4dSLi1+4AAABXhyUfAF2KNR/ALDdmJWwX1nwAAAiHVXe6rZ8n2bVLO0RLzYlW8faJ087QcoI1HwAAOmTtq2myBueat+bjiI/XTrBdZknJ/LoVK36s3WEa9/TpS883NGhnALBRbEaGdgKALsSSDwAA+Cpqpwx3v6IdAQBANLm05jNKu0OTw2HuuSmXNR8AADpyac2nl3aH3RoemqedoIH3lGyWPHp0uYj4tDsAAMDVY8kHQJdzOpjzAUwyMDuRNR8AAMJj/euW4y/NLsgcox2ipTpwTvqlm/e0+iUnpt3qXrZ2N2s+AACEYO3/vKlwiIFrPk4D13yyn3zysWMvv/xz7Q5T9Ln33p+1HTumnQHARq7sbO0EAF2MJR8AAPBV1bHmAwDAVSnQDoCOm3JY8wEAoCNrDF3zqbv/Me0EDa8m5+eXa0cYpEw7AAAAfDUs+QDoFoz5AGYZlJNYKVWs+QAAEAbrjcq6Fx4ebe6az6f+c3KN27yn1S9hzQcAgI5Z+2uaCm/KTTRuzccRF6edYLuUceNWn9m2bbx2R0+X+fjj81trarQzANgozuvVTgDQDbjkAwAAuoJ/2i3uZWv38EEVAABhKhCRSu0ILSY/GzA4J2nzWvFzSRoAgBDW7G546l9y+24VkVPaLXaqnfSw5JSu1M6w26rk/PxiLvp0r7TJk5drNwCw19lt27QTAHQDLvkA6DZO5nwAowzKSaoUPqgCACAc1sqtdS98L98zRjtEyx8bWuTrGQnaGVpOseYDAECHrP2fNxUOzknaoB1iN0e8eWuHqUVFK7nk033SJk9+VUTatTsAAMBXxyUfAADQVfjaCQAArk6hiGzWjtBi8rMBQ3KTNq/dzSVpAABCWbvbv2Dwd5I2i2FrPjV3Txfvf7yjnWG3Ncn5+Q9z0ad7uGfMeK69sVE7A4CNYtLStBMAdBMu+QDoVjFO7QIAduKDKgAAwmat2lb//EMGr/kcrm+R6zzmrvn83a3uZb/ikjQAAKFYBz5vKhxk4JqPMzFRO8F2fSZPXs4ln66XOn78OhGp1e4AAABdg0s+AACgK/FBFQAAV8cSkQrtCC0Gj/nIkNykil9xSRoAgJDW7vEv+Od7kipF5IR2i50+te6Tayre186w24bk0aPLz2zdykWfLuSePn1p+8mT2hkAbBTTu7d2AoBuxCUfAN3OafL+PmCgod5efFAFAEB4rLe21S95cJS5az4f17XIDZnGrvmcvf/WjBfX7G7gtRMAAJdnfVjbVDAwJ9G4NR9HXJx2gu3S7r//R1zy6TrJo0eXi4hPuwMAAHQdLvkAAICudvb+ERkvrtnFB1UAAIRprIhs1I7Q4jD44YAh3qTNa3YLl6QBAAhh7R7/gsX35G0XEb92i52OjL5H+m/9d+0Mu21MLizccGbz5iLtkJ6gz733/qzt2DHtDAA2cmVnaycA6GZc8gFgC4PfrweMNNSbVLFmFx9UAQAQBuvt7fWLHrzNs3GIN0m7RU1be1A7QQuXpAEA6Jj1YW1zwcDsxA+0Q+zmjI/XTrCde8aMpVzy6TJl2gEAAKBrcckHAAB0h5YHRmS8+C4fVAEAEC6j13xMNiQ3afMa4ZI0AAChrNvjf2JRUV6lGLbmc3j4nXJd1W+1M+xWmWJZH5yuqJigHRLNMh9/fH5rTY12BgAbxXm92gkAbMAlHwC2cbLmAxhlWF7SxndZ8wEAIBzW2zvqFy2bdE2FiLRrx2hwxThY8+GSNAAAoVgf1jYX3Gjgmo8jIUE7wXbuWbN+yCWfryZt8uTl2g0A7HV22zbtBAA2cGoHAACAHqtt+siMpdoRAABEGct39OzYYFDE1ONwmHuGepMq5OKaDwAAuIz1Vf4nRCRTu8NuH99YqJ2gwZcyZkyZdkS0Sps8+VUx9MEBAAB6OpZ8ANjK6WDOBzDJsLxeG9/Z2cCaDwAAYXhnZ8MzQ729NolIm3aLhhiHQ9qDxq758JWnAAB0zProWPOoG7ISzFvziYnRTrBdxuzZT5/etGmidkc0cs+Y8Vx7Y6N2BgAbxaSlaScAsAlLPgAAoDu1z7jN85zwRDoAAOGwfDVnx1wIBsXU4xAx9rDmAwBAxy6t+eRod9jt4HX52gkaDqaOH79OOyLaXFpAqtXuAAAA3YMlHwAA0N02isgi7QgAAKLJ6p0Nz7x4b7/fiUiLdgtsx5oPAAAdsz463jJqQGZCmXaI3ZwJCdoJtvPMnTv/VHn5VO2OaJJeXPyjtvp67QwANnJ5PNoJAGzEJR8AKvZ/3qSdAMAmDofIg6M8z729vX6R8LVdAAB0luWrabKG5Cb9RjtES4zB28PD8pI2vrtL+MpTAABCeK/KP++pb3l3ikiNdoud9ntvliE1e7Uz7Fbdu6ho9ckNG4q1Q6JBcn5+uYhs1+4AAADdh0s+AADADqz5AAAQpjW7Gp4a8t1+m0XkrHaLhvYLRl/0aSsembF09U7WfAAACME6VNcy8npPglGXfEREJNa8j3UyHnlkPpd8Oif17rtXttXyTV2ASVw5xn2DJWA8c98uA6DO6eBwOCadh/I9i0WkQvu/ewAAiCLW/pqmwgvBoJh6HAb/Nczba5Pw2gkAgJDeq/LPExGvdofd9mUO1k7QUJs2ceIb2hFRYo12AAAA6F7mXfkGAABa+JAKAIAwrdnd8NS/5PbdKiKntFs0tLZfkDhz53zapo/MWPoOaz4AAIRiHaprHnl9ZqJxaz5Ol0s7wXYZc+YsbCwrm63dEck8c+cubqsx7n8dAKO5vMbddQUgXPIBoMyhHQDAVt/L9zy7alv98yLCh1UAAHSOtf/zpsKbcpI2aIdocRj8S8OwvF4b39nZUCG8dgIA4LLe3xuYt/Au7x4RqdZusVNV2g0yvPFj7Qy7+dOmTHm1cf3672uHRKq0adOWaTcAsNeZLVu0EwAoMPZxOAAAoGKzdgAAANFm7W7/AhHpo92hpbntgnaCpvbpIzOWakcAABDBrD/UNd+i/RWjGkdiY407GXPmLNT+D1yk6jNhwioRadHuAAAA3Y8lHwDqnCY/mgsY6OHRmU+v3Fr3gvBEOgAAnWX9/vOmgoE5icau+ZiMNR8AADr2/t7AvCfH5/pE5Ih2i512J39dbj3zR+0Mu51KLy5eHli9ep52SKRxz5y5uL2xUTsDgI1i0tK0EwAoYckHAADYrVI7AACAaLN2j3+BiLi1O7ScbW3XTtDUPuM2z3PaEQAARDDrcH3LcAmKmHacLpdxxzN79oKu+Y9Nz5FiWR+IYV9ZBwCAyVjyARARGPMBzDK7IPPpNypZ8wEAIAzWh7XNBQOzEz/QDtFi8u8Mw/KSKn65Q1jzAQAghNK9gZIn78ytEsPWfHbG9ZWRrZ9pZ9itzT1r1lL/m28+ox0SKdKmTn2l7fhx7QwANnJlZWknAFDEkg8AANDAmg8AAGFat8f/hBi85nO6xew1nwcvrvlUaIcAABChrMMNLcMviIhpZ3tc3y75AUaZZ7UDIkVyfn658BoRAACjsOQDIGI4TX40FzDQI7dnLfzXLcdfEp5IBwCgs6wPa5sLbjR4zedkc7v0TozRztCyUUQWaUcAABCpSvcGSp64M3efiBzWbrFbYO1a7QRbOePixPPoo8/Wv/ba89ot2lLvvnvleb9fOwOAjWLdxj77A+ASLvkAAAAt2ycOS19R5gtwyQcAgE5aX+V/4tm787aLSJ12i5Z9R5u0E9Q8eJvnubd31C8SLkkDAHA51h/rW4b2z4g37pLPoen/KAPe+b+0M+y2VESMv+QjImu0AwAAgL245AMgojDmA5glM8VVLRcnhfmgCgCAzrE+OtY8akBWgrFrPn3T4+SzQKt2hhbWfAAA6ECpL1Dyj+NyjFzzccTHayfYLrOkZH7dihU/1u7Q4pk7d3FbTY12BgAbubxe7QQAEYBLPgAAQNMu1nwAAAjP+ir/E09/27tLRGq1W2A/1nwAAOiQdaTh3NBr3Oat+Ryc/AMZ+N5PtTPs9oqIGHvJJ23atGXaDQDsdWbLFu0EABGASz4AIo6TNR/AKNmpriPCmg8AAOGwPj7eMmpAZkKZdoiWvLQ4OdrImg8AAPiyUl+gZN7YnAMicki7xW5OA9d8sp988rFjL7/8c+0Ou/WZMGGViLRodwAAAPtxyQcAAGirYs0HAIDwvFfln/fUt7w7RcTcfX6DHw54cJTnube3s+YDAEAI1qf+c4P7pccbd8nnwD1zZPC/v66dYbdXk/Pz7zuzbdt47RA7uWfOXNze2KidAcBGMWlp2gkAIgSXfABEpBjmfACjePvEfSKs+QAAEA7r4+PNI6/PTDT2kk9u7zj5/CRrPgAA4MtKfYGSv/9mzkEROajdYjdHXJx2gu1Sxo1bbdIlnxTL+kBEqrU7AACADi75AACASOBjzQcAgPC8vzcwb+Fd3j1i8Bv8Jj8aMHOUZ/EvttcvES5JAwBwOVZ14NzAvunxxl3y2Td+pgwt/4V2ht1WJefnF5ty0Sdt6tRX2o4f184AYCNXVpZ2AoAIwiUfABHL5DfsARPl9Yk7JKz5AAAQDutQXfOI6zwJxl7yyUp1yfFTbdoZWiq0AwAAiGSlvkBJialrPvHx2gm2Sy0qWmnCJZ/k/Pxy4XUgAABG45IPAACIFAcmDUtfUcqaDwAAnVa6N1Dy5PjcKhE5ot2ixWHw0wEP5XsWv7WNNR8AAEKwPgucG+jtE2fcJZ+qwmkyfPNa7Qy7rUnOz3+4p1/0SRk3bnVbba12BgAbuXJytBMARBgu+QCIaE6nwe/YAwa6NKPNmg8AAJ1nHa5vGf71jARjL/lkJLuk4QxrPgAA4MtKfYGS/2VlHxKRA9otdnMmJmon2K7P5MnLe/olHxFZpR0AAAB0cckHAABEkoOs+QAAEJ7SvYGSJ+7M3Scih7VbYD/WfAAA6JB19ETrAG+fOOMu+ey6dYKM2P2BdobdNiSPHl1+ZuvWHnnRxz1z5rLWzz7TzgBgo7i+fbUTAEQgLvkAiHhO7QAAtromPf6AsOYDAEA4rD/WtwztnxFv7CUfd69Y8Z89r52hhTUfAAA6UOYLlPzAyv5ERHzaLXZzxMVpJ9gu7f77f9RTL/mkFxcv1W4AYK8zv/uddgKACMRn5wAAINIcmjQsfYV2BAAA0aTUFygRkeu0OzQ5DD7fy/c8K1z2AQAgFKvmROu1F4Iipp3tg7+l/bPXsDG5sHCDdkRX611UtFpETml3AAAAfSz5AIgKTq4kAkbpnxG/T1jzAQAgHNaRhnNDr0k3d82nT2KsnGg2ds1ns3YAAACRrMwXKHnsG9lHRKRKu8Vuzvh47QTbuWfMWHpm8+Yi7Y6ulD59+pLzfr92BgAbxbrd2gkAIhQfmwMAgEh0eNLNrPkAABCOS2s+A7Q7NDkcDmPPrNGZrPkAABCaVXuytX8wGBTTTuV1Rj4/VZliWR9oR3SVS8tEh7Q7AABAZGDJB0DUcDoc2gkAbHRtRkKVsOYDAEA4rE8D5wb3TY839gOAlIQYOd3Srp2hhTUfAAA6UOYLlHz/jiwj13wcCQnaCbZzz5r1w9MVFRO0O7pC2pQpy8/X12tnALBRrMejnQAggrHkAwAAItUR1nwAAAjPpTWfgdodmhwGn4dHZz4trPkAABCKdexUW/+giJh2NueN6pIfYJTxpYwZU6Yd8VUl5+eXi0i5dgcAAIgcLPkAiCqM+QBmuc7Dmg8AAGGyPgucG+jtE3dQO0RLUpxTmlovaGdoqdQOAAAgkpX5AiWP3pFVLSK7tFvs5oiJ0U6wXcbs2U+f3rRponbHV5FcWPjrtqNHtTMA2MiVl6edACDCseQDAAAi2ZH7bk5frh0BAEA0ubTmM1i7AzpY8wEAoEPW8VNt/YJBEdPOf2eP0P7ZaziYOn78Ou2Ir+in2gEAACCysOQDIOo4mfMBjHJ9ZuIeYc0HAIBwWEdPtA7w9ok7oB2iJTHOKc2s+QAAgMso8wVK5haauebjTEjQTrCdZ+7c+afKy6dqd1wN98yZy9rq6rQzANjIlZmpnQAgCnDJBwAARLrq+25OX/7+3gCXfAAA6KQyX6DkB1b2JyLi027RYvKzAbMLMp9+o7LuBeGSNAAAl2PVnW7r50l2GXfJ5//0HizfPGncPfDq3kVFq09u2FCsHRKu9OLipdoNAOx1+re/1U4AEAW45AMgKjkNfsMeMNENWYk7hTUfAADCYdWcaL02J9Vl7CWfuBiHtLYHtTO0sOYDAEAHynyBkkduz6oRke3aLbaLNe9joYxHHpkfbZd8ehcVrRaRU9odAAAg8pj3ag4AAESjmsnD3cvfq/JzyQcAgE4q8wVKHrsj64iIVGm3aDH52YA5BZkLX6+se0m4JA0AwOVY/7rl+EtzCjLHaIfYbWPSDTK26WPtDLvVpk2c+EZjWdls7ZDOSp8+fcl5v187A4CNYt1u7QQAUYJLPgCiFms+gFluzErYLqz5AAAQDqv2VFv/zBSXsZd8nE6HXLhg7JqPecsEAACEb5QY+H8znS6XdoLtMubMWRgtl3ySCws3iMgh7Q4AABCZuOQDAACiRe2U4e5X1rPmAwBAp5X5AiVzC7OqRWSXdosagx8OmHN75sLXt7DmAwBACNbrlXUvPTzavDWf/4z9utx1/o/aGXbzp02Z8mrj+vXf1w65krQpU5afr6/XzgBgo1iPRzsBQBThkg+AqOZ0GPyOPWCggdmJrPkAABAeq+50Wz9PssvYSz4OcUhQzF3zmTgsfUWZL8BrJwAAQisQkUrtCNvFmvfxUMacOQsj/ZJPcn5+uYiUa3cAAIDIZd6rOAAAEM3qpt7ifmXdHtZ8AADorDJfoOSR27NqxMCvovgzh8FzPp5kV41wSRoAgFCslVvrXjByzUf6yV1SrZ1ht1PpxcXLA6tXz9MOCSW5sPDXbUePamcAsJErL087AUCU4ZIPgKjndGoXALDToJzESuGDKgAAwmHVn2nzZvQy+y0Ah7kroKz5AABwZUau+ThdLu0E23lmz14QyZd8ROSn2gEAACCymf0OHwAAiEb+abe4l61lzQcAgE4r8wVK5hRkmr3mY+wdH5HMFFe1cEkaAIBQrJVb6174Xr5njHaI3Ta0ZktR3DHtDLu1uWfNWup/881ntEP+VvoDDyxvranRzgBgozivVzsBQBTikg+AHsHk+X3ARINykipF/HxQBQBA51mvV9a9ZOJXUfzZhfagxMYY+3vDLtZ8AAC4okIR2awdAVs8KyIRd8nHPX3689oNAOx1etMm7QQAUYhLPgAAIBqdmHare9na3az5AAAQJiO/igKs+QAAcAXWqm31zz9k4JrPv7dmy+iyFdoZtnLGxYnn0UefrX/ttYi5VJM6fvw6EfFrdwAAgMjHJR8APUaMU7sAgJ2G5CZtXrubNR8AAMJgrdxa98Isg9d82tqD4mLNh9dOAACEZsnFS7Ho+ZaKSMRc8nFPn770fEODdgYAG8VmZGgnAIhSfCQOAACi1an7b814UTsCAIAoVKgdAB1fWPMBAABfZr21rX5JMChi2qm8t0Qc8fHGncySkvna/6ETEUkePbpcRHzaHQAAIDqw5AOgR3E6jH0qFzDSEG/S5jW7+doJAADCYL25tc7Ir6L4s3PngxIfa+wzT6z5AABwZaz5mOMVEfmxdkSfe+/9WduxY9oZAGzkys7WTgAQxbjkAwAAotnZ+0dkvLhmVwMfVAEAEB6jP7wy+dmArNS/rPnw+gkAgC+zfrG9fsmDt5l3IXrztx6Vb2xapZ1hu+wnn3zs2Msv/1w5o0z5nw8AAKIIl3wA9Dgmv2EPmGioN6lizS4+qAIAIAzWW9vql8wcZd6HV3/W3HpBEuNY89EOAQAggo0VkY3aEbDFq8n5+fed2bZtvMY/PPPxx+e31tRo/KMBKInzerUTAEQ5LvkAAIBo1/LAiIwX32XNBwCAcJm95qMdoCg71XVEWPMBACAU6+0d9YsevM2zcYg3SbvFVo3T/z+Svu517QzbpYwbt1rrkk/a5MnLNf65APSc3bZNOwFAlOOSD4AeKYY5H8AoN+f12vjurgY+qAIAoPP+8lUUQ/PM+vDqiz6pb9FO0FLFmg8AAFdk5JpPYOocEy/6rErOzy+2+6JP2uTJr4pIu53/TAAAEP245AMAAHqCtukjM5a+s5M1HwAAwmTkh1d/ZvKjATms+QAA0BHr7R31i5ZNuqZCDLyE4YiP106wXWpR0Uq7L/m4Z8x4rr2x0c5/JABlMWlp2gkAegBjv4AeQM/ncHA4HJPOsLxeG8XgrxwBAOAqWG/vqF8kIjHaIVq+7knQTtBUNXFY+grtCAAAIpjlO3p2rHaEBv93H9RO0LAmOT+/3K5/WOr48etEpNaufx4AAOg5WPIBAAA9RfuDt3meu/RhJU+kAwDQOdbeo2fHDvP2su0DjYjjcGgXqMnpHceaDwAAHXhnZ8Mzlx4qMm7Nx5mYqJ1guz6TJy+3a83HPX360vaTJ+34RwGIEDG9e2snAOghWPIBAAA9ibFfNwIAwNV6Z0fDM2Lwmk9/t3lfR/EFrPkAANAxy3f07NgLwaCYdo7fOVn7Z69hQ/Lo0d1++f3SP8PX3f8cAADQM7HkA6DH2/95k3YCALs4RB4c5Xnu7e2s+QAAEAZr79GzY4fkJhm75uM0d8xHvH3iPhHWfAAACOmdnQ3P/Mjbb5OItGm32M0RF6edYLu0++//0ZmtW7t1zafPvff+rO3Yse78RwCIMK7sbO0EAD0ISz4AAKCnYc0HAIAwrd7Z8IyIJGh3aMnrY94HWF/gY80HAIAOWb6jTWODQRHTTu0dE7R/9ho2JhcWbujmf0ZZN//9AQBAD8aSDwAjmPxkLmCih/I9i9/aVr9EeCIdAIDOsvbVNFmDc5N+ox0C+7HmAwBAx97d1fDUUG+/ChFp0W6xmzPevK82dc+YsfTM5s1F3fH3znz88fmtNTXd8bcGEKHivF7tBAA9DJd8AABAT1ShHQAAQLR5d1fDU0u/22+ziJzVbtGQ2ztOPj/Zqp2hxTdxWPqKMl+ASz4AAFye5atpsoYYeCH6s5F3Sd+d/6mdYbfKFMv64HRFRZdPGaVNnry8q/+eACLb2W3btBMA9DBc8gFgDMZ8ALN8L9/z7Kpt9c8LT6QDANBZ1v7PmwoH5yQa9+HVn5n8O0Nen7hDwpoPAAAhrdnV8NQQQy9EOxLM+1ZX96xZP+zqSz5pkye/KiLtXfn3BAAA5uGSDwAA6Kk2awcAABBt1uxqeOr5CX2N/PBKRCQ71SXHTrVpZ2g5wJoPAAAdMvZC9KeD75BrDvxOO8NuvpQxY8pOb9o0sav+hu4ZM55rb2zsqr8dgCgQk5amnQCgB+KSDwCjOB0mP5sLmOfh0ZlPr9xa94LwRDoAAJ1l7f+8ybopJ2mDdogWk39l6JvGmg8AAB0x+UK0IyZGO8F2GbNnP91Vl3xSxowpE5Harvh7AQAAs3HJBwAA9GSV2gEAAESbX+32L3juO0mbReSUdosGT7JL6s+Yu+YzaVj6ilLWfAAACMXa/3mTNTjXvAvRRwYWSP+Dxr3NcjB1/Ph1p8rLp37Vv1F6cfGP2urru6IJQJRweTzaCQB6KC75ADCO0+AncwETzSnIXPh6Zd1LwhPpAAB0lnWgtqlwULZ5H179mcPgOZ++6fEHhTUfAABC+tVu/4LBuWZeiHYmJGgn2M4zd+78r3rJJzk/v1xEtndREgAAMByXfAAAQE+3feKw9BVlPJEOAECnrd3tX/DP9yRVisgJ7RYN6UmxEmg6r52h5SBrPgAAdMja/3lToYlfb/qHr90i1/9pj3aG3ap7FxWtPrlhQ/HV/g1S7757ZVst39QFmMSVk6OdAKAH45IPACOZ/GQuYCJPsqtGeCIdAIBwWB/WNhXcmJ1o3IdXf2bybwz9WPMBAKBDa3f7Fyz5jqEXomPN+1gp45FH5n+VSz4isqbLYgAAgPHMezUGAABMxJoPAABhWrvHv2BRUd52EfFrt2jonRgjJ5vbtTO0sOYDAEDHrN9/3lQwyMA1n0PeoTKgZp92ht1q0yZOfKOxrGx2uP+DnrlzF7fV1HRHE4AI5fJ6tRMA9HBc8gFgLKdTuwCAnbJSXdXCE+kAAITD+rC2uWBgduIH2iFaTF7zuSY9/oDw2gkAgJDW7jH3602dLpd2gu0y5sxZeDWXfNKmTVvWHT0AIteZLVu0EwD0cHzEDQAATLFr4rD0FdoRAABEk/VV/idEJFO7Q0tKQox2gqZDk3jtBABAR6wPa5sKLgSDYtr50HOj9s9egz9typRXw/kf6DNhwioRaemeHAAAYCqWfAAYjZuOgFlyUl1HhCfSAQAIh3XwWPOoG7ISjF3zMXnO5xo3az4AAHTE6K83jTXv46WMOXMWNq5f//3O/vvdM2cubm9s7M4kABEmJi1NOwGAAfh8GwAAmKSKNR8AAMJzac0nR7tDS684o986Yc0HAICOWQePNRdoR2j4MO067QQNp9KLi5d35t+YYlkfiEh19+YAAAATmXfVGgD+htNp8KO5gIG8feI+EZ5IBwAgHNZHx1tGDchMKNMO0WLyrwz9M+L3Ca+dAAAIad0e/xOLivIqxcA1H6fLpZ1gO8/s2QsCq1fPu9K/L23q1Ffajh+3oQhApHBlZWknADCE0Y+jAQAAI/lY8wEAIDzvVfnniYhXu0NLfKzRb58cZs0HAIAOWR/WNhdcCIqYdvb1ukb7Z6+hzT1r1tKO/g3J+fnlcvGSNAAAQJdjyQcARMTgB3MBI+X1iTskPJEOAEA4rI+PN4+8PjOxRjsE9mPNBwCAjq2v8j/x7N1520WkTrsFtnhWRJ4J9f+ZevfdK8/7jRt2AowW63ZrJwAwCJd8AACAiQ5MGpa+otQX4IMqAAA66f29gXkL7/LuEZFq7RYNrhintLVf0M7QcpjXTgAAdMj66FjzqAFZCR9oh9htb1I/6bfqx9oZtnLGxYnn0UefrX/ttedD/FvW2BoEAACMwiUfALjE6WTPBzBJ3/T4g8IT6QAAhMP6Q13zLdd6Eoy85HORub8z9M9IYM0HAIAOrK/yP/H0t727RKRWuwW2WCoiX7rk45k7d3FbDeOXgElcXmO/2RqAEi75AAAAUx3kiXQAAMLz/t7AvCfH5/pE5Ih2i4YYp4i5Yz6s+QAAcAXWx8dbRg3ITCjTDrHbpw/Nl6+t+Yl2hu0yS0rm161Y8VczRmnTpi3T6gGg48yWLdoJAAzDJR8A+ALGfACzXOOOPyA8kQ4AQDisw/Utw6/NSDDyko+IiMPg3xm+7mHNBwCAjrxX5Z/31Le8O0WEKRczvCIif7nk02fChFUi0qJWAwAAjMAlHwAAYLJDPJEOAEB4SvcGSubfmVslhq75OEQkqB2h5/Ckm9NXlO7ltRMAACFYh+paRl7vSTDuks+Rv3tcri37f7QzbJf95JOPHXv55Z+LiLhnzlzc3tionQTARjFpadoJAAzEJR8A+BtOkx/NBQzUP4Mn0gEACJP1SUPL8P5uc9d8TF4AvTYjoUp47QQAQEjvVfnn/dNdrPkY5NXk/Pz7HPHxLSJSrR0DAAB6Pi75AAAA0/FEOgAAYSrdGyj5x3G5+0TksHaLhgtBoy/6HOG1EwAAHbIO1TWPvD4z0bhLPocnzpXrN6zSzrBdyrhxq105OUfajh/XTgFgI1dWlnYCAENxyQcALsPgN+wBI/FEOgAAYbOONLQMvcYdb+QlHxGRGIMXQK/jtRMAAB16f29g3sK7vHuEZRdTrNIOAAAA5nBqBwAAAESAI5NuTl+hHQEAQDQp9QVKRGSAdoeWtgtB7QRNvHYCAKBj1qG65hEXgkEx7Xx890PaP3sAAIAejSUfAAiBNR/ALNd7EnYJT6QDABAO61P/ucH90uMPaYeoMfh3hus8rPkAANCR0r2BkifH51aJyBHtFrt9fPdDcsN/vKWdAQAA0COx5AMAAHBR9X03py/XjgAAIJpcWvMZqN2hpfU8az7aEQAARDDrcH3L8GBQxMTz0bdZ9AEAAOgOLPkAQAecDoMfzQUMNCAzcafwRDoAAOGwqgPnBualxR3UDtHidJj7/NSAzESWEAEA6EDp3kDJ/DvNXPMBAABA9zD3nSgAAIAvq5k83L1cOwIAgGhyac1nsHaHlqbWdu0ETSwhAgDQMeuThpbhQREx8RxkzQcAAKDLseQDAFfAmA9glgGZCaz5AAAQHuuzxtYB3j5xB7RDYL/rMxP3CK+dAAAIqXRvoOSJO3P3ichh7RYNB7/9kAz8329pZwAAAPQYLPkAAAD8tZopw92vaEcAABBNyi6u+QzT7tBy5hxrPtoRAABEMOuP9S1Dg8GgmHo+/NZM7T8DAACAHoMlHwDohBjmfACj3JiVuF14Ih0AgHBYNSdar81Jdfm0Q7SY/BvDgMxElhABAOhAqS9Q8o/jcoxd8wEAAEDXYckHAADgy+pY8wEAIDyX1nyGa3doOdl8XjtBUw1rPgAAdMg60nBu6IWgiKnnwF2s+QAAAHQFlnwAoJOcXIsEjDIoJ7FSqngiHQCAMFi1p9r6Z6W6qrRDtJg8AHpDFms+AAB0pNQXKJk3NueAiBzSbtFy4K6ZMvg/f6GdAQAAENX4yBoAAODy/FNvYc0HAIBwXFrzGaHdoSXQZPaaz+Th7uXaEQAARDDrU/+5wcGgiMln/3gWfQAAAL4KlnwAIAwmP5kLmGhQTmKl8EQ6AADhsI6fauuXmeLapR0C+w3ITGDNBwCADpT6AiV//82cgyJyULsFAAAA0YklHwAAgND8025xL9OOAAAgmpi+5uM/y5qPdgQAABHMqg6cGxgMBsXks+/OB7X/HAAAAKIWSz4AECYncz6AUW7KTaqUPX6eSAcAoPOsutNt/TKSY41d8zH5V4YbshK2C2s+AACEVOoLlJSMyTZ+zWffnQ/K0N++rZ0BAAAQdVjyAQAA6NiJabey5gMAQDgurfmM0u7QUne6TTtBU+2U4e5XtCMAAIhgVnVj68ALQRHTz95xLPoAAACEiyUfALgKToOfzAVMNCQ3afPa3az5AAAQBuv1LXUvzS7IHKMdosXkXxluyErYJaz5AAAQUpkvUPK/rOxDInJAuwUAAADRhSUfAACAKzt1/60ZL2pHAAAQhQq0A7QcO8Waj3YEAAARzDp6onVAUERMP1Ws+QAAAISFJR8AuEpOh8nP5gLmGeJN2rxmN0+kAwAQBuuNyroXZo02eM3H4N8ZbsxO3C6s+QAAEFKZL1DyAyv7ExHxabdoqxr3oAz/r7e1MwAAAKICSz4AAACdc/b+Eaz5AABwFQq1A7TUnGjVTtBUx5oPAAAdsmpOtF57ISjCEdk9lkUfAACAzmDJBwC+Aqe5D+YCRhrmTapYs4sn0gEACIP15ta65x/K94zRDtFi8q8MA1nzAQCgQ2W+QMlj38g+IiJV2i0AAACIDiz5AAAAdF5L8ciMpdoRAABEIWMveVQ3ntNO0MSaDwAAHbNqT7b2DwaDwgnKrm/O0P7zAAAAiHgs+QDAV+R0mPxsLmCeYd5em1bvbOCJdAAAOs96a1v9kpmjzF3zMRlrPgAAdKzMFyj5/h1ZrPlcsuubM2TE//mldgYAAEDEYskHAAAgPG3TWfMBAOBqGHvJ49MAaz7aEQAARDDr2Km2/heCIpyLZ8cYFn0AAABC4ZIPAHQBh4PD4Zh0huX12igXn0gHAACdY/1ie/2SYFDE1KP9+kXzDMpJrBReOwEAEFKZL1AiIiO0OwAAABD5uOQDAAAQvvYHb/M8J3xYBQBAuMZqB2g50mD0mo9/6i2s+QAA0AGr7nRbP+2ISMKaDwAAwOXFagcAAABEqY0iskg7AgCAKGK9vaN+0YzbPBuHepO0W1ScOdeunaBmYPZf1nws7RYAACJRmS9QMrcwq1pEdmm3RIodY2bIbZt+qZ0BAAAQUbjkAwBdaP/nTdoJAOziEHlwlOe5t7fXLxI+rAIAIBxj5eJlWeMkx8eYfNHHP/UW9yvr9vh53QQAwOVZdafb+mUkx3LJ5wu2WdMlv+Id7QwAAICIwdd1AQAAXD0jP6AEAOArsH65o36RiMRoh2hxOMw9g3L+suYDAAAuo8wXKBGRUdodABBtagqKtBMAwDZc8gGALuZ0cDgck85D+Z7FwodVAACEw/IdPTv2QjAoJp5El9Fvxfin3eJeph0BAEAEs17fUveSBEU4/3O2fWP6V/yxAujJjt1+j3YCANjK6HeWAAAAugAXfAAACNM7OxueERGXdocWh8F/DcpJYs0HAIArY83nb3DRB8DlfM6CDwADxWoHAEBP5HQ4tBMA2GjW6Mxn39xa97yIWNotAABECct3tGnsEG/Sb7RDNMTFOqT1fFA7Q8uJabe4l63d4+d1EwAAl2e9Xln30sOjM8doh0SayjumS8Hv3tHOABAhqvPv5oNuAEZiyQcAAOCr26wdAABAtHl3V8NTIpKg3aHF4TD33JTLmg8AAJ1QoB0AAJHqwM13aScAgBou+QBAN3FwOByjzsOjM58WPqwCACAc1r6aJisYFDHxxDod2j9/TSem3epeph0BAEAEs1ZurXshKCKcvz5b7uBruwDTHbv9Hu0EAFDFJR8AAICuUakdAABAtFlzcc2nl3aHFu1LyppncE7SZuGCNAAAV1KoHRCJuOgDmGvnoDu1EwBAHV9VCADdyOyHcwHzzCnIXPh6Zd1LImJptwAAECWs/TVNhTflJv5GO0SDw3Fx1cdQp6bd6l62dref100AAFye9ebWuue/l+8Zox0SiTYXFkvh5tXaGQBs5Bs6XuS8ub9AAcCfseQDAADQdbZPHJa+QjsCAIBosmZ3w1MikqrdocXhMPcMyWXNBwCATmDNB4DxagqKtBMAIGKw5AMA3czJnA9glMwUV7Vc/LCKp9IBAOgca//nTYU35SRt0A7RYvCvDKf+7lb3sl+x5gMAQCjWqm31zz/Ems9l/a6wWO5gzQfo8X5/813SRzsCACIISz4AAABdaxdrPgAAhGftbv8CEXPft3UYfIbkJlUIaz4AAFwJF2JD+F1hsXYCgG607cZx2gkAEHFY8gEAGzjMfTIXMFJWKms+AACEyfr9500FA3MSjVzzuRAUcZk753P2/lszXlyzu4HXTQAAXJ711rb6JTNHseYTyn/fXizf2MKiD9DT7Bh058VflgAAf4UlHwAAgK7Hmg8AAGFau8e/QETc2h1aHA6HsWeIN2mzsOYDAMCVcCEWgDF2DLpTOwEAIhaXfADAJk4Oh2PUyUl1HRE+rAIAIBzWh7XNBcGgiInn3PkL2j9/TWfvH5HxonYEAAARzPrF9vol2q9XIvlUFPC1XUBPsesmLvgAQEec2gEAAAA9VBVrPgAAhGfdHv8TYvCaj8mG5LLmAwBAJ4zVDohkXPQBot/uweO1EwAg4sVqBwCASZxOh3YCABt5+8R9Ihc/rLK0WwAAiBLWh7XNBTdmJX6gHaKhufWCJMYZ+zzW2ftHZLy4ZlcDr5sAALg86+0d9Ytm3ObZONSbpN0SsQJT50j6ute1MwBchSou+ABApxj7zhEAAIANfKz5AAAQnvVV/idEJFO7Q4vDYe4Z6k2qENZ8AAC4EtZ8riAwdY52AoAw+YZywQcAOoslHwCwGWM+gFn6psUdEtZ8AAAIh/XR8eZR12cmGLnmc7qlXVISYrQztLQ8MCLjxXdZ8wEAIBTrlzvqFy2bdE2FiLRrxwBAV/ANvUtEgtoZABA1WPIBAADoXgcmseYDAEBYLq35eLU7tDgMPqz5AABwRZbv6FnWfK6ANR8gOuwfdpd2AgBEHZZ8AECB08GcD2CSfunxB4U1HwAAwmEdqmsZeb0noUY7RMPJ5nbpnciaj3YIAACR6p2dDc8My+u1UVjz6VBg6hxJX/e6dgaAEA5wwQcArgpLPgAAAN3vIGs+AACE570q/zwxec3HYe4Zlpe0UVjzAQCgI9beo2fHXggGhdPxaZgyW/vPCsBlfDj8W9oJABC1uOQDAEq03zjncDj2nmvc8QeED6sAAAiHdaiueWRQREw8jU1GP5jfVjwyY6l2BAAAkWz1zoZnRMSl3QEA4TrIBR8A+Eq45AMAAGCPQ6z5AAAQnvf3BuaJSD/tDthvqDdpk3BBGgCAjli+o01jLwRFOB2fusms+QCR4qNbuOADAF9VrHYAAJjM6XBoJwCwUf+MhH1y8cMqS7sFAIAoYR2qax5xXUZCtXaIBv+Z8+JONvatm7bikRlLV+9s4HUTAAAhvLur4akh3n4VItKi3RLp6ibPlsz33tDOAIz28a3fujhbCgD4SljyAQAAsM/hSTez5gMAQDhK9wZKRKS/docWh8F/DfP22iSs+QAA0BFrX02TFQyKcK58jt/Hog+g5Q+3fls7AQB6DGMfBwOASBHDmA9glOsyEqqENR8AAMJhHW5oGd7fnXBEO0TD8dNtkpXi0s7Q0jZ9ZMbSd1jzAQAgpDW7Gp4a8t1+m0XkrHYLAFzO4RHfZsEHALoQSz4AAAD2OsKaDwAA4bm05nOddocWh8PcMyyv10ZhzQcAgI5Y+z9vKgwGg8K58jk26WHtPy/AKJ+MZMEHALoaSz4AEAGcTuZ8AJMMyEzcJaz5AAAQDutIQ8vQr7njD2uHaKg92So5veO0M7S0s+YDAEDH1uxqeOr5CX1Z8+mkY5MeluzSldoZQI/3x9tY8AGA7sCSDwAAgP2q77s5fbl2BAAA0aTUFygRkQHaHbAfaz4AAFyRtf/zJisoFz9P51z51LLoA3SrP426WzsBAHosLvkAQIRwcDgco86AzMSdwodVAACEw/qT/9zgC0ERE0/NiVbtn7+m9hm3eZ7TjgAAIJL9ard/gYikancAwKdc8AGAbsUlHwAAAB01k4e7l2tHAAAQTS6t+QzU7tDicJh7huUlVQgXpAEA6Ii1//OmQu2LydF0aiay5gN0tc/yueADAN0tVjsAAPA/nFy9BIxyQ1bCdrn4YZWl3QIAQJSwqgPnBualxR3UDtFQHTgn/dLjtTO0tD94m+e5t3fULxJeOwEAcFlrd/sXLPlOUqWInNBuiRY1Ex8Wb9lK7QygRzg6ukgkGNTOAIAej4+TAQAA9NROGe5+RTsCAIBocmnNZ7B2h5bqwDntBE0btQMAAIhw1u8/byoIBi9+zs7p3Dl6L4s+wFdVU1CknQAAxmDJBwAijFMc2gkAbHRjViJrPgAAhMf6rLF1gLdP3AHtEC37jjZpJ6hhzQcAgI6t3eNf8M/3sOYDwD61txeJMOADALZhyQcAAEBXHWs+AACEp+zims8w7Q4tqYkx2gmaWPMBAKBj1u9rm+64EAwKp/On+ruztP/cgKh07PZ7tBMAwDgs+QBABHJyBRMwyqCcxEqpYs0HAIAwWDUnWq/N6R3n0w5RY/AA6IOjPM+9vZ01HwAAQlm3x//EoqK8ShHxa7dEk+rvzpJ+//amdgYQNY4X3sOCDwAo4GNkAAAAff6pt7DmAwBAOC6t+QzX7tCSHM+aDwAACMk6eKy5IBgU4YR3Pp3Aog/QGccLWfABAC1c8gGACOVwcDgck86gnMRKEanQ/u8eAACiiFV7srV/MBgUU49DxNgzc5RnsfDaCQCAkNbt8T8hIpnaHQB6nt/2/6Z2AgAYjUs+AAAAkcE/7Rb3Mu0IAACiielrPklxRr+twwUfAAA6Zh081jwqKBe/TYfT+fMn1nyAkH77dS74AIC2WO0AAEBoMQ6HdgIAGw3OTdq8do+/QkQs7RYAAKKEdexUW//MFFeVdogWk39leCjfs/itbfVLhNdOAABc1voq/xPP3p23XUTqtFuizZ8mzJKvffCmdgYQUTZe+82LN+EAAKqMfuQLAAAgwpyaditrPgAAhOPSms8I7Q4t8bFGv7XDmg8AAB2zPjrWPOpCMCic8M8fv/M97T8/IGL8n2tZ8AGASGH0O0EAEA2cDg6HY9IZmptUIXxgBQBAOKy60239gkERU4/JHsr3LBZeOwEAENL6Kv8TIpKj3QEgem26bqx2AgDgC7jkAwAAEFnO3n9rxovaEQAARJNLaz6jtDu0xMUY/fYOF3wAAOiY9fHxllHal5Kj9Xxyz/e0//wAVRVc8AGAiGP0u0AAEC0cDgeHwzHoDPEmbRY+sAIAIBzWv245/pL2VzpoHoeIsed7+Z5nhddOAACE9F6Vf56IeLU7ohUXfWCq/76eCz4AEIm45AMAABB5zj4wgjUfAACuQoF2gJYYp0M7QdNm7QAAACKc9fHx5pHaqzjRfA4XfU/7zxCw1e8GcMEHACJVrHYAAKBzzH7PHjDPUG9Sxbu7pEJELO0WAACihPVGZd0LD4/OHKMdosXhMPeXhlmjM599c2vd88JrJwAALuv9vYF5/3SXd6eI1Gi3AIhsW24Yd/F2GwAgIrHkAwAAEJlaikdmLNWOAAAgChm75mPuFR8RYc0HAIArsQ7VNY8Migjn6s4fWPOBAbbcME47AQBwBSz5AEAUcRr8ZC5gomHeXptW72xgzQcAgM6zVm6te+F7+Z4x2iFaTP6d4eHRmU+v3Fr3gvDaCQCAy3p/b2Dewru8e0SkWrslWv2h6Hty/YZV2hlAt9h647iLN9oAABGNJR8AAIDI1Tb9NtZ8AAC4CoXaAVoumD2rX6kdAABAhLMO1TWPuBAMCufqz8d3P6T95wh0uW03suADANGCJR8AiDJOrmcCRrk5r9fGd3aw5gMAQBisVdvqn3/I4DUfk7HmAwBAx0r3BkqeHJ9bJSJHtFsARIYdg+4UuWD0wwIAEFX4qBgAACCytT94m+c5EanQDgEAIMoYe8mjnTUfAAAQmnW4vmV4MCjCufrz0bdZ80HPsHPQndoJAIAwcckHAAAg8m3UDgAAIMpYb22rX3IhePGBVBOPOMw9DxdkPi1ckAYAIKTSvYESEemv3RHtuOiDaLfrJi74AEA04uu6ACBK7a9p0k4AYBOHQ2Tm/7+9fw+zq67TRd9vVaWuuRBmXZJKJYEIgiBQuQCBoKtsbe0+y9VaIYh4AVtE+3hWb9rd2rJFN7QsMUf2Zp+cOn+cfbHttr0hKqQPuzmL7ersHqfTwUAgRNOmzQqmjYRAJRVCoJJKVSo5f6RAUFJJQdX8jTnH55NnPJIQn+dFH+OY8/eOdyxvv/1vN+79chR4lQAAXod3RkHLsiOjx6O+riZ1jFSs+QDA+Hqe3De0ZFFr087UQSrdz//gY3HhQ99MHQMm7PGL3n1ilgqAiqPkAwBQGTyNDgAT0/OtjXtvu/7y9nUXd7WkzpLEL549nDpCMp9Y0XHrX23o/2ooSAPAa7r/if03//m75v00InakzgKU1+aL3p06AgBvgJIPQAWrKeyDuVBMH7ui/fZv/sSaDwBMUGHXfM6f01zkoo81HwAYX8/OfUOXLGprVPJ5g37+BzekjgATcyx1AADeiNrUAQAAOG3WfABgYnq+9cje2yKiLnWQVGoKfN20ouOWcP8EACd1/5b9N0fEualzAABw+iz5AFS4WnM+UCgfv7LjS3/9cP9XwpoPAJyuni1PDb7zkq7pP04dJIU3dzTHf+0v7JrPxtQBACDnenbuO3LJWSVrPgAAlcKSDwBAZVmfOgAAVJrvPLrvixFRnzpHMqkndRJeN11lzQcAxjO25nNe6hwAAJweSz4AVcCYDxTLjSs6bv3Ghv6vhjUfADhdPVt2D77j4nkthVzzOaetKZ7cN5Q6Riobe7tLfWu37HffBACvredX+49ctLDUuD11EAAATs2SDwBA5dmQOgAAVJrvnljzaUqdI5WaAv9on1G/O6z5AMBJja35XJA6BwAAp2bJB6BK1FrzgUK56aqOW77+z/1fC2s+AHC6erbsPtRz8byWh1IHSeHs1sb4t4EjqWOkYs0HAMbXs2v/kQvmn9mwLXUQAADGZ8kHAKAybeztLvWlDgEAleSeTfu+EBHTU+dIpaamuFfHzPpdYc0HAE5qbM3notQ5AAAYnyUfgCpSW2POB4rkFYdVnkoHgNPT87Pdh9721nnNhVzzWXBmQ/z6ueHUMVLZZM0HAMbV8+vnhs+bP7tha+ogAACcnCUfAIDKtcmaDwBMzD2P7ftCRMxKnYPys+YDAONba80HACD3LPkAVJlaYz5QKHNn1e8Maz4AMBE9P3v60Nve2tnyYOogKXTNbojdB6z5pA4CADnV89SB4fO6rPkAAOSWJR8AgMq22ZoPAEzMvY8NfD4iZqfOkUpNTXGvObOs+QDAeMbWfLpT5wAA4LVZ8gGoQjU15nygSDrPaLDmAwAT0/MvTx9acUFncyHXfObOqo9nDo6kjpGKNR8AGF/P7gPD53TOqt+SOggAAL/Lkg8AQOWz5gMAE3Tv4wOfj4jW1DlSqSnw9YrXnQIAr2FszWdJ6hwAAPwuSz4AVarWmA8UStfshifDmg8ATETPz/ccXnHB3OYHUgdJoWNmffS/UNg1n83WfABgXD17Do4smjurfnPqIAAAvJolHwCA6rDFmg8ATMwPHh/4bFjzKeTVac0HAMZlzQcAIJ8s+QBUMWs+UCwLzmzYHtZ8AGAien6+5/CKtxR0zad1Rn0MvGjNJ3UQAMipnmcOjizqmGnNBwAgTyz5AABUj60rrfkAwIT8cPPAZyOiI3WOZGpqCnt1ntFgzQcAxjG25nNp6hwAAPyGJR+AKldbY84HimRhqXFbWPMBgIno+ddnDi8/b05TIdd8zmypi+cOjaaOkYo1HwAYX0//CyMLO2bWb0odBACAEyz5AABUl23WfABgYsbWfDpT50iltqa4V9fshifDmg8AnJQ1HwCAfLHkA1AAdSqdUCiL2hp/GtZ8AGAien7x7NDy8zqa1qYOksKspro4OFTYNZ8t1nwAYFw9/S+MLGybMc2aDwBADjj2BQCoPjus+QDAxPxo88BnIqIrdQ7Kz5oPAIxvbM1neeocAABY8gEojJqamtQRgDJ6U3uTNR8AmJieXzx7+LI3dzTvTh0khRmNdfHiEWs+qYMAQE71fP2f+7/2iRUd70gdBACg6Cz5AABUpx0rF1vzAYCJuO+J/Z+JiIWpc6RSU+Br/uyG7WHNBwBOZUXqAAAARWfJB6BANDuhWM5ta9oc1nwAYCJ6tvcfvvTc9qZdqYOk0NxQG4eHj6WOkcpWaz4AMK6ev9rQ/9Ubr7TmAwCQkvNeAIDqtdOaDwBMzP1P7L85IhalzpFKTU1xrwVnWvMBgNNgzQcAICFLPgAFU1tbkzoCUEbndTRvCms+ADARPTv2Di15U1vTztRBUmiYVhvDR635pA4CADnV842H+7/6cWs+AADJWPIBAKhuu65eXFqTOgQAVJKxNZ9zU+eg/Kz5AMBpeVvqAAAARWXJB6CAjPlAsZw/p/nRsOYDABPR88u9Q5csamvckTpICvV1NTEyejx1jFS2ruwu9d1vzQcATqbnrx/u/8ofX9H+jtRBAACKyJIPAED1271qSeua1CEAoJLcv6XYaz41NTWFvRaUGreFNR8AOBVrPgAACVjyASioGms+UCjnz2naGNZ8AGAienbuO3LJWaVirvnURsSx1CHS2WbNBwDG1fM3P9n7lY9Z8wEAKDtLPgAAxbDnmiWtd6cOAQCVZGzN57zUOVKpKfC10JoPAJwOhVgAgDKz5ANQYLXmfKBQ3jK32ZoPAExMz6/2H7loQalxe+ogqRT4E4M1HwAYX883f7L3y9cvt+YDAFBOlnwAAIqj35oPAEzM2JrPBalzpJJ6USfldVapcWtY8wGAU3ln6gAAAEViyQeg4GoL/GguFNGFnc0bYrM1HwCYgJ5f7z9yQdfshm2pg6RwLCKmFfdDw3ZrPgAwrp5vbdx72/WXt69LHQQAoCgs+QAAFMvAB5Za8wGAiRhb87kodY5kUk/qJLzOarXmAwCnwZoPAECZWPIBIGprCvtkLhTSWztb/ukHMWDNBwBOX89TB4bP65rdsDV1kBRGRo9HfV1hPzNY8wGA8fV865G9t3308vZ1l3S1pM4CAFD1LPkAABTPgWuXtt6VOgQAVJK1J9Z8ulPnSKW2prjXorbGn4Y1HwA4FWs+AABlYMkHgIg48eU1UBwXzWtZf+/j1nwAYAJ6dh8YPqdzVv2W1EFSODx8PJobCvus2A5rPgAwrp5vP7L3trtWnpVFxGjqMAAA1ayw384AABTcwQ8us+YDABMxtuazJHWOdGoKey1qa7LmAwDj69ny1OA7jx+PcLlcxbkAKD9LPgC8zJoPFMvF81qy7z9mzQcAJqBnz8GRRR0z6zenDpLCi0dGY0ZjXeoYqVjzAYBT+M6j+754Sdf0f4yIkdRZAACqlSUfAIDiGrzu0rbVqUMAQCUZW/O5NHWOVGpqinu9qd2aDwCcQs+W3YPvOB5++OFHkX4AUF6WfAB4lZoacz5QJBfPa1l/z4nDKk+lA8Dp6el/YWRh+4z6TamDpHDw8GjMai7wms/iUt/9T1jzAYCT+e6j+754SdfCfwxrPgAAU0LJBwCg2AY/dGnb6u9t2uewCgBO09ot+2/+5FVzdkfExtRZUijyYwHntDVtDgVpABhPz5anDr3z4q6Wh1IHAQCoRko+APyO2iJ/aw8FdElXS/a9TQ6rAGACeva+ONLVNr2YX6scOHQ0ZrcU8589InZa8wGA8X1v074vXNy1MIuIodRZAACqTW3qAAAAJDf0kcva7kwdAgAqydot+2+OiOWpc6RSU+Dr3N+s+QAAr63np7sP9Rw/HuFyuYpzAVAehX3sCoDx1ZnzgULpnj993Xce3WfNBwBOX8/XN/R/7cYrO96ROkgKA4NHo7WgS0ZhzQcATumeTfu+cPH7Fq6PiMHUWQAAqklhv40BAOBVRj96efsd335k7z+kDgIAFWZFRGxIHSKJAj8XcG77y2s+ij4A8Np6frb70Nsumtf8UOogAADVxOu6ADipmhqXy1Wkq3t+SxZePQEAE9HzjYf7v3o8Iop47Xvx6GT8Z1ipdq5cXOpLHQIA8uyex/Z9ISKmp84BAFBNLPkAAPCS0esvb7/jW4/svS08lQ4AE/G2iFifOkQKtTU1qSMkc15H86aw5gMA4+n52dOHet7a2fJg6iAAANXCkg8AAK+0LnUAAKgwPX/9cP9Xjh0/HkW8njk4nPo//5R2Xb24tCZ1CADIs+8/NvD5iJiVOgcAQLWw5APAKf1s96HUEYAyqamJuGF5++1/u3Hvl8NT6QAwET3htZeF8+aO5sfDmg8AjKdn655Db7PmAwAwOSz5AADw2xxQAsDE9HzzJ3u/fOx4RBGvp5+35pM6BADk2b0n1nxmp84BAFANLPkAcFpqalInAMrpY1e03/7Nn1jzAYAJemcU9NWXRf64cF5H86NhzQcAxtPzL08fWnFBZ7M1HwCAN0jJBwCA12LNBwAmpudbG/fedv3l7esumd+SOksSAy8eTR0hld1XLy6tue+J/Uo+AHAS9z4+8Pnb3zt/Y0QMpM4CAFDJlHwAOG115nygUG68suPWbzzc/9XwVDoATERh13xaZ0yL/YPFLPqcP8eaDwCcQs/P9xxeccHc5gdSBwEAqGS1qQMAAJBbG1IHAIAK0/OtR/beFhF1qYNQdruvXlxakzoEAOTZDx4f+GxEtKbOAQBQySz5ADAhxnygWD6xouPWv9pgzQcAJqDniacG39ndNf3HqYOkcGbLtHjukDWf1FkAIKes+QAAvEGWfAAAGI81HwCYoO88su+LYc2niHavWtK6JnUIAMizH24e+GxEdKTOAQBQqSz5ADBh1nygWG66quOWr/9z/9fCU+kAcLp6nnhq8J0Xz2sp5JrPrKa6ODg0mjpGEud1NFnzAYDx9Wx75vDyt8yx5gMA8HpY8gEA4FQ29naX+lKHAIBK8t1H930xIppS56DsrPkAwClY8wEAeP0s+QDwutSa84FC6ZhZvys8lQ4AE9Hz092Hei6a1/JQ6iApzGisi8HhYq75nD+naWO4bwKA8fT867OHl583p8maDwDABFnyAQDgdGyy5gMAE/O9Tfu+EBHTU+eg7PZcs6T17tQhACDPxtZ8OlPnAACoNJZ8AHjdao35QKHMnVW/MzyVDgAT0fOzpw+97aLO5kKu+bTU18bhkWOpYyRx/pymTeG+CQDG0/OLZ4eWn9fRtDZ1EACASmLJBwCA07XZmg8ATMw91nyKypoPAJzCjzYPfCYiulLnAACoJJZ8AHhDamrM+UCRdJ7RYM0HACam52dPH+p5a2fLg6mDpNA4rTaGR4+njpHEW+Y2bwz3TQAwnp5fPHv4svM6mnenDgIAUCks+QAAMBHWfABggr7/2MDnI2JW6hyUXb81HwAY331P7P9MWPMBADhtlnwAeMNqjflAoXTNbngyPJUOABPRs3XPobddOLeYaz7Tamti9Fgx13wusOYDAKfSs73/8GVvtuYDAHBaLPkAADBRW6z5AMDE3HtizWd26hyUnTUfADiFsTWfhalzAABUAks+AEyKOms+UCgLz2zYFp5KB4CJ6Pn5nkMr3jK3uZBrPjUF/rxwYWfzhtjsvgkAxtGzvf/wpee2Ne1KHQQAIO8s+QAA8HpsW2nNBwAm5N7HBz4fEa2pc1B2Ax9Yas0HAMZz/xP7b46IRalzAADknSUfACZNbZEfz4UCOqvUuDWs+QDARPT8fM/hFRfMbX4gdZBUivqR4YK5zRvCfRMAjKdnx76hJee0Ne1MHQQAIM8s+QAA8Hptt+YDABPzw80Dn42IjtQ5KDtrPgBwCtZ8AABOzZIPAJOqVn0UCmVRW+NPw1PpADARPdueObz8/DlNxVzzOR4xra6Ycz4XdlrzAYBT6Hly39CSRa3WfAAATsZRLAAAb8QOaz4AMDFjaz6dqXNQdgPXLm29K3UIAMizsTWfc1PnAADIK0s+AEy6mppiPpkLRfWm9iZrPgAwMT3/+uzQ8vM6mtamDpLC8NHj0TitmM+dXdjZsiFiwH0TAJxcz859Q5csamvckToIAEAeFfMbFQAAJtOOlYut+QDARPxo88BnIqIrdQ7K7oA1HwAY3/1brPkAAJyMJR8ApkStMR8olHPbmzaHNR8AmIieXzx7+LI3dzTvTh0khcMjx6KloZjPnr11XsuGeNyaDwCMo2fnviOXnFWy5gMA8NuK+W0KAACTbac1HwCYmPue2P+ZiFiYOgdld+DaZdZ8AGA8Y2s+56XOAQCQN5Z8AJgytTXmfKBIzuto3hTWfABgInr+a//hpee0N+1KHSSFF4+MxszGutQxkrios2X9vWHNBwDG0fOr/UcuWlBq3J46CABAnljyAQBgsuy6enFpTeoQAFBJxtZ8FqXOQdkdtOYDAOMbW/O5IHUOAIA8seQDwJSqNeYDhXL+nOZHw5oPAExEz469Q0vOaWvamTpICgeHRuOM5mKu+Vw8r2X9vY9Z8wGAcfT8ev+RC+af2bAtdRAAgLyw5AMAwGTavWpJ65rUIQCgktz/xP6bw5pPER38oDUfABjX2JrPRalzAADkhSUfAKZcjTUfKJTz5zRtDGs+ADARPU/uG1qyqLWYaz7PHRqNUkth13yy71vzAYDx9Pz6ueHzumY3bE0dBAAgDyz5AAAw2fZcs6T17tQhAKCSjK35nJs6B2U3eN2yttWpQwBAnq09sebTnToHAEAeWPIBoCzqzPlAoVwwt9maDwBMTM/OfUOXnNXauCN1kBT2DR6NtunF/JrqonnN6+Mx900AMI6e3QeGz+ma3bAldRAAgNQs+QAAMBX6rfkAwMTcf+Ip9fNS56DsrPkAwClY8wEAOKGYj0gBkIQxHyiWCzubN8RmT6UDwAT0/GrgyEULSo3bUwdJof/FozFnZn3qGElc3NWy/h5rPgAwnp7dB4bP6ZxVb80HACg0Sz4AAEyVgWuXtt6VOgQAVJKxNZ8LUueg7Aavu9SaDwCMZ2zNZ0nqHAAAKVnyAaCsas35QKFc2NmyIWLAU+kAcPp6fr3/yAXzz2zYljpICs8cHI65sxpSx0ji4nkt6+8Jaz4AMI6ePQdHFp3X0bQ5dRAAgFQs+QAAMJUOXLvMmg8ATMTYms9FqXNQdtZ8AOAUxtZ8FqbOAQCQiiUfAMquTsUUCuXieS3r733Mmg8ATEDPr58bPq9rdsPW1EFSePr54eiaXcw1n0u6WrJ7NlnzAYBx9Pxy35HupQun70odBAAgBcesAABMtYMftOYDABMy9pR6d+oclN3Qh6z5AMC4frh54LMR0ZQ6BwBACpZ8AEiiJnUAoKwunteSfd+aDwBMRM/uA8PndM6q35I6SAq/3n8kFpYaU8dI4pKulux71nwAYDw9//rM4eURkaUOApRP2wzH2gARSj4AAJTH4HWXtq2+Z9M+h1UAcJrWbtl/86ffPmdnRGxOnYWyGvrQpW2rv+e+CQBO6m837v3yn7+r8x2pcwAAlJuSDwDJ1Nba84EiuaSrJbvHU+kAMBE9ew6OLDq7tbGQJZ9nXxiJubPqU8dIont+yzprPgBwSudGxI7UIQAAyknJBwCAcvFUOgBM0Not+2/+zDs7t0bE9tRZKKuRD1/Wdud3H3XfBAAn0bNr//AFoeQDhVLUhwAAXknJB4CkjPlAsXgqHQAmrOdXA0cuuqCzuZAln4NDo3FGUzG/vurumv6P3310n/smADiJH24e+Oyf9sx9IHUOAIByqk0dAACAQhn5yGVtd6YOAQCV5P4t+2+OiM7UOSg7900AcGoXpQ4AAFBOxXwUCoBcqa0x5wNF0j1/+rrveCodACai57/2D126bOH0Qj6pfjyOF/Yzg/smABhXz+7nh8+74uyZW1MHAQAoF0s+AACU2+hHL2+/IyKy1EEAoFL84PGBz0ZEfeoclN2oNR8AOLn7n9h/c7hHAgAKxJIPAAAprIuI21KHAIAK0rP92aHLImJD6iApvGVuc+oIyVjzAYBx9fzb/iMXRcTm1EGA8pnRaMcCKC4lHwBy42e7D6WOAJRJTURcf3n7Hd96ZO9t4cAKAE7L/kNH515Q0LLLc4eOxpkthf0aa/Sjl7ff8e1H9v5D6iAAkEfPHhw+K5R8oFBmtDeljgCQTGG/HQEAIDlrPgAwAWu37L/5grldGyNid+osKdTUpE6QTvf8luzbj4Q1HwB4Dfc9sf8zf/HueWtT5wAAKAclHwBypchf3EMR3bC8/fa/3bj3y+HACgBOR8+Te4e6o6Alnyf3Rlx29ozUMVIZtYIIAONaFBE7U4cAAJhqSj4AAKSUpQ4AAJXk3scHPv/n7+p8MHWOVPY8PxydZzSkjpGKFUQAeG09v35u+LxQ8oFCeWtnMV9lDKDkA0Du1FrzgUL54yvav/Q3P9n7lfBUOgCcrnMjYkfqEKn89KlDqSMkY80HAF7bPZv2feE//dGCh1LnAACYako+AACktj51AACoID2/fm74gihwyadpWm3qCClZ8wGAk5sVEQdThwAAmEpKPgDkUm2NOR8okhuv7Lj1Gw/3fzU8lQ4Ap/SDxwc++4U/6HogdY6UnjownDpCMtcvb7/jWxut+QDAb+l5+vmRcyJic+ogQPksPLOwr/IFCkzJBwCAPNiQOgAAVJiuiNidOgRJWPMBgNew94WR+aHkA4Wi5AMUkZIPALllzAeK5RMrOm79qw3WfADgNPQ8dWD4/ChwyafoHxVuWN5++99u3PvlcN8EAC/74eaBz65+/8JCrx0CANVPyQcAgLyw5gMAp+mFodHZqTOkNqupLnWElLLUAQAgp5oiYih1CACAqaLkA0Cu1ZrzgUL55FVzbvnf/vnZr4Wn0gFgXGu37L/5c78/777UOVLa++JI6ghJfeyK9tu/+RNrPgDwCj3PHhxZGBHbUwcByqfzDK/sAopFyQcAgDzZ2Ntd6lu7Zb/DKgA4tUURsTN1iFTaZ9QXvehjzQcAfsvA4NH5oeQDhaLkAxSNkg8AuWfMB4qlY2b9rjhxaKXoAwAn1/P088PnRoFLPhER9XXF/rBgzQcAXu3FI15pCgBUNyUfAADyZpM1HwA4tUPDx2amzpDaGc11qSOkZs0HAF7h/i37b/5a71mFfqUpAFDdlHwAqAi1xX5AFwpn7qz6nWHNBwDGtXbL/pu//B8WFP4Q65f7hlJHSMqaDwD8jvqIKPQ7PQGA6qXkAwBAHm225gMAp2V2RBxInIG0rPkAwG/07D90tDMidqUOApSPhU+gSJR8AKgYtTXmfKBI5p3R8GRY8wGA8fTse3FkfhS85ONTQsQfX9H+pb/5yd6vhPsmAIj9g0o+UDRKPkCRKPkAAJBXW6z5AMD4Bk4cYm1NnSO1hrrCV33Wpw4AAHnx/NDR1tQZgHJrTB0AoGyUfACoKLWF/+4eimX+7IbtYc0HAE7q0PCxmakz5EFji6+4Pn5lx5f++uF+az4AFN7w0eNNqTMAAEwV34AAAJBnW1d2l/rut+YDAK9p7Zb9N0fEfalzpPbxKztSR8gDaz4AEO6PoIguP3tG6ggAZaPkA0DFqTXnA4WyoNS4Laz5AMBJ3fm+hakj5MKTe4dSR0juxis7bv3Gw/1fDfdNABTcV9/v/ggAqE61qQMAAMApbFvZXepLHQIAcmx66gDkxobUAQAgJ7yyCwCoSpZ8AKhIWqpQLGeVGreGNR8AeC09B4dGWyNiMHUQ8sGaDwBEzwsn7o92pw4CADDZlHwAAKgE21d2l/ru37LfYRUA/JZDw6OzUmfIg+mNtTF45FjqGHlgzQeAwjs8cszSIQBQlZR8AKhYteZ8oFAWtTX+NKz5AMDvcIj1GzU1qRPkwydWdNz6Vxus+QBQXEeOHnd/BABUJSUfAAAqxQ5rPgDwu46MOMR6ScM0LZ8x1nwAKLQhJWgAoEop+QBQ0Wo9qguFck570+aw5gMAr2LJ5zcap9WljpAbN63ouOXrG/q/Fu6bACggJR8AoFop+QAAUEl2rlxc6rv/CWs+APCSo8eO16fOkBf7Bo9G23Rfd43ZmDoAAKRy5Oix5tQZAACmgm89AKh4xnygWM615gMAr7J2y/6bI+K+1Dny4qarOlJHyI2bruq45ev/bM0HgOI5djxqU2cAAJgKSj4AAFSanVcvLq25z5oPAMCpbOztLvWt3eK+CYBiUYKG4lnZnjoBQHko+QBQFWrN+UChvLmj+fGw5gMAvIaa8Nngldpn1O8O900AAABQFcwVAgBQiXZdvbi0JnUIACB//rd/fjZ1hLzZ2Ntd6ksdAgAAAHjjLPkAUDVqPbALhXL+nOZHw1PpAMBrMPT5ah0z63eF+yYAAACoeJZ8AACoVLtXLWldkzoEAEAF2GTNBwAAACqfJR8Aqoo1HyiWt8xp2hieSgcAOCVrPgAAAFD5LPkAAFDJ9lyzpPXu1CEAgHz5X9c/mzpCHlnzAQAAgApnyQeAqlNbY84HiuSCuc3WfACA3+Fjwe+aM8uaDwAAAFQySz4AAFS6/g8steYDAHAarPkAAABABbPkA0BVqlVjhUK5sLN5Q3gqHYCCUtp4bYZ8XtvcWfU7w30TAAAAVCRHoAAAVIOBa5e23pU6BACkUFdbc6yutiZcr772vng09X81ebVZMQwAAAAqkyUfAKpWjWd3oVAu7GzZEDHgqXQACqdpWs1g6gx55RPBa+u05gMAAAAVSckHAIBqceDaZa133fvYgMMqAAqlub72YOoMVJzNvd2lvrVb9rtvAqAqrbRaB8XzdOoAAOWh5ANAVavzYkoolIvntay/9zFrPgAUS2N97VDqDHl17Njx1BFyy5oPANWscVqtpUMAoCop+QAAUE0OXresbfU9j+1zWAVAYVjyGd/gkdHUEfLKmg8AVauxvkYJGgCoSko+AFS92pqa1BGAMrq4q2X9PY95Kh2AwshmNtU9lzpEng0OH0sdIbc6z2iw5gNAVbLkAwBUKyUfAACqzeB1l7atvmeTNR8ACuNA6gBULGs+AFSl5nolHwCgOin5AFAIxnygWC7pasnu2eSpdACK4fb//depI+Taf+yZmzpCrnXNbngyrPkAUGUap9Uo+QAAVUnJBwCAajT0oUvbVn/Pmg8AwKlsseYDQJXJWhrqDqYOAQAwFZR8ACiMOnM+UCiL509f971N+zyVDkBVu2ZJ692pM1D5rPkAUIUOpA4AADAVlHwAAKhWIx+5rO3O7zxqzQeA6jW7ua4/dYa8OzJyLBrra1PHyDtrPgBUlb/8e68zhSL5y/cuSB0BoGyUfAAoFGM+UCzd86ev+86j1nwAqF6l6dP2pM5QCQ4NH0sdIffmz27YHtZ8AAAAINeUfAAAqGajH728/Y5vP7L3tnBgBUD1yZR8Ts+h4eHUESrBVms+AFSDlYtLfakzAABMFSUfAACq3bqIuC11CACYIiOpA1QCi56nZ8GZ1nwAqHwzGuoOpM4AADBVlHwAKKSfPX0odQSgTGpqIq5f3n7HtzZa8wGguvR2l/p+svPF1DEqwoIzG1JHqBRbV3aX+u635gNABZvdUtefOgMAwFRR8gEAoAis+QBQdc5orhtInaFS1JjyOW0LSo3bwpoPAJUrO7PF60wBgOql5ANAYdX6nh8K5WNXtN/+zZ/s/XI4sAKgOmRzZtbvTB2ikgwdPZ46QqXYZs0HgAqnCA0AVC0lHwAAiiJLHQAAJtmu1AEqiY7/6VtozQeACnbHg0+ljgCU0W3/fn7qCABlpeQDQKH5oh+K5Y+vaP/S3/xk71fCgRUAVeCuHz+dOkJF+bPf60wdoZJY8wGgIl29uLQmdQYAgKmk5AMAQJGsTx0AACbDdcvaVqfOUGkU/CfmrFLj1rDmA0CFObNlWn/qDAAAU0nJB4DCq63xdT8UyY1Xdtz6jYf7vxoOrACoYHPPqN+ZOkPFOZ46QMXZbs0HgAqTtc2o964uAKCqKfkAAFA0G1IHAIA3KJt3RsOTqUNUmqefH04doeKc1WrNB4CKsyt1AACAqaTkAwARUWvMBwrlphUdt3x9Q//XwoEVABWot7vUFxGjqXNQCNZ8AKgYvd2lvl88ezh1DKCMzp/TnDoCQNkp+QAAUEQbe7tLfWsdWAFQgc5orhv4lz2HUseoOK3TfQ32eixqa/xpWPMBoAI01dcOps4AADDVfLsBAGNqasz5QJG0z6jfHQ6sAKg82cIzG7elDlGpBocNIL0OO6z5AFAJ5s6s35k6AwDAVFPyAQCgqKz5AFCp+lMHqFyK/a/HorYmaz4A5F3WMat+V+oQQHk9f1iJHygeJR8AeAVjPlAsHTPrd4UDKwAqyIcubVu9Y+9Q6hgVq/OMhtQRKpU1HwAqgZskAKDqKfkAAFBkm6z5AFBBsrNbG7emDlHJhkePp45Qsd7Ubs0HgPy6blnb6p8+dSh1DKCMLpnfkjoCQBJKPgDwW+qs+UChdM6q3xkOrACoHLtTB6CwdqxcXOq7/wnlaAByJ+s6s+HJ1CEAAMpByQcAgKLbbM0HgEpw3aVtq3cOHEkdo6LNn+11XW/EOW1Nm0M5GoB82pE6AABAOSj5AMBrqK015wNF0jW74clwYAVAvmVnl7yq6406eszrut6gndZ8AMibld2lvl/uHUodAyijN7U3pY4AkIySDwAARGyx5gNAnvV2l/rCq7rIAWs+AORNafq0Z1JnAAAoFyUfADgJWz5QLPNnN2wPB1YA5NQZzXUDew4Op45R8dpn1KeOUA2s+QCQJ9mCMxt/njoEUF4vHBlNHQEgGSUfAAA4YevK7lLf/dZ8AMif7LyO5k2pQ1SDA4eOpo5QFc615gNAToytHR5InQMAoFyUfABgHLW19nygSBaUGreFAysAcmbl4lJfRAymzgGvYM0HgFyY1VQ38Mt9Q6ljAGX0pram1BEAklLyAQCA39hmzQeAnMm6zmjYvud5r+qaDM0NtakjVI1z2635AJBctqitcWvqEAAA5aTkAwCnYMwHiuWs1sat4cAKgHxxeEUeWfMBIKmxV3UNpM4BAFBOSj4AAPBq2635AJAXH728/Y4Dh0dTx6ga0xvrUkeoKud1NG8K5WgAEpnZVHfgl/uOpI4BlNGb2hpTRwBITskHAE5DbY05HyiSRW1NPw0HVgCkl10wt3lj6hDV5uCQ0tQk2nX14tKa+6z5AFB+2ZvaGrekDgEAUG5eRA4AAL9rx8rFpb7UIQAotmuWtN4dEYOpc8B43tzR/HicKEcDQNms9KouAKCgLPkAwGmqNeYDhXJOW9PmsOYDQDrZm9oatzx/+GjqHFWnxkrnZLPmA0C5ZR2z6nc9c3AkdQ6gjObOqk8dASAXLPkAAMBr22nNB4BUxp5O35U6RzWqcU36dV5H86NhzQeA8tqUOgAAQAqWfABgAqz5QLG8ub1pU1jzAaD8sgVnNmwbGjmWOkdVammoSx2hGu225gNAuXxgaevd+wetHUKRlKY70gZ4iT8RAQDg5Lx+AoCy6z2x4rMtdY5q5W1dU+P8OS+v+bhvAmAqZWe3Nm5NHQIor4NDo6kjAOSGkg8ATFCNUwEolDd3ND8eDqwAKJ9s7qz6ncOjx1PnqFrTUweoXrtXLWld86PNA+6ZAJgyY2XonalzAACkouQDAADj2+XACoAy25w6ALwe53U0WfMBYCplbdOn7X7Oq7qgUM70qi6AV/GnIgC8DrXGfKBQHFgBUCbZJ1Z03DpixYfKZc0HgKm2MXUAAICUlHwAAODUdl+zpPXuHzqwAmDqbUgdoNp5++7UOn9O08ZQjgZgClx3advqF4ePpY4BlNGMhtrUEQByR8kHAF4naz5QLOfPadoUDqwAmDrZTSs6bkkdAibBHuVoAKZA9pY5zVZ8oGCeeu5I6ggAuaP+CAAAp2fPNUta704dAoDq1Ntd6guvnyiLGteUX68oRwPApLh6cWlNRBxIHAMAIDlLPgDwBtSZ84FCubCzeUNstuYDwKTL5syq35U6BEwiaz4ATKbsnPamLYPDo6lzAGU0vaEudQSAXLLkAwAAp2/gA0ut+QAwucZWfDalzlEUNTU1rjJcb5nbvDGs+QAwCVaeuFfamToHAEAeWPIBgDeoxpgPFMqFnc0bIqz5ADBpsrNLjVtTh4Ap0G/NB4BJkJ3V2rh1ZPR46hxAGdXX+dId4GQs+QAAwMQMXLu09a7UIQCoDquWtK6JiO2pcxRJjats1wXWfAB4g8YWD90rAQCMseQDAJOg1pwPFMpb57VsiMcHrPkA8EZlF8xt3pA6BEwhaz4AvBHZ/NkN249a8YFCmWbFB2BclnwAAGDiDly7zJoPAG/MdcvaVkdEf+ocRVNT4yrn9YpXnQLAhIyt+HitKQDAK1jyAYBJUusBAyiUi+e1rL/3MWs+ALxu2ZIF09elDlFEg8OjqSMUzcAHlrbe/YPHrfkAMCHZ/NkNXtMFAPBbLPkAAMDrc3BsgQEAJiq78cqOWyNiJHUQKIex19JZ8wHgtK204gMA8Jos+QDAJKqtMecDRXJxV8v6ex4Laz4ATMjYodWG1DmgjKz5ADAR2VmtjQo+UDBHR4+njgBQEZR8AADg9Ru87tK21fds2ufACoDTlZ3b0bQ5ImLfoCGfcmtpqA29/DQu7Hx5zcd9EwDjWrm41BcRXtUFAPAalHwAYJLVOjSAQunuasnu2eTACoDTc+2y1rsiYmfqHJCANR8ATkd2XkfzptQhgPI6cvRY6ggAFUPJBwAA3pihD1/Wdud3H7XmA8ApZZcunPFQ6hBFNjg8mjpCoVnzAeBUrlnSendE7EqdAwAgr5R8AGAK1HoHABRKd9f0f/zuo/scWAEwnuyTV825JSK0TCiygWuXtt51rzUfAF5bdtG8ln9KHQIor8MjVnwAJqI2dQAAAKgCIx+5rO3O1CEAyK9VS1rXRMTG1DmKrsaP5D8u7Gx5ac0HAF4p+9Clbasj4kDqIAAAeWbJBwCmiDEfKJbu+dPXfceaDwCvLevualkXETHkKVU4YM0HgJPwWlMAgFNQ8gEAgMkxev3l7Xd865G9t4WiDwC/kd24ouPWiDiYOgiK+Hnx1nktG+LxAeVoAF6Sfeptcz4XEfH088OpswBlMu+MhtQRACqS13UBAMDkWZc6AAD5snJxqS8iNqTOATlz4NplrXelDgFAPqzsLvVFxKbUOQAAKoElHwCYYj97+lDqCEC51ERcv7z9jm9ttOYDQEREZJd0tWQREaPHj6fOQkTUmfLJjYs6W9bfG9Z8AIjs/DnNG1OHAMpr/6GjqSMAVCxLPgAAMLms+QAQEZF94sRrugZSB4GcOmjNB6Dwsg9f1nZnROxOHQQAoFJY8gGAMqj1wDAUyseuaL/9mz/Z++XwZDpAYa1a0romvKYrdwz55MvF81rW3/uYNR+Aouo98ZquH6fOAQBQSZR8AABg8mWpAwCQVHbpwun/OXUIftfRY16bljMHP7is9a7vPzag5ANQPNmCMxu2R0QMDo+mzgKUyfSGutQRACqekg8AlEmtx4ahUD5+ZceX/vrh/q+EJ9MBiib7v/27uX8WEUOpg/C73JHnz8XzWrLvW/MBKJwPLG29OyK2ps4BAFBplHwAAGBqrE8dAICyy65d1npXRGxJHQQqyOB1y9pW3/PYPiUfgOLIli6Y7jVdUDBPPz+cOgJAVVDyAYAy8uQwFMuNV3bc+o2H+78ankwHKITe7lJfRDyYOgev7djxiBrrmrl0cVfL+nseC2s+AMWQ/cnb53wurB4CALwuSj4AADB1NqQOAEDZZBd2Nj/80k9eODKaMguvYXpDXeoInNzgdZe2rb5nkzUfgGp3zZLWuyNiU+ocAACVSskHAMqs1sPDUCg3rei45esb+r8WnkwHqGbZTSs6bomIPamDQKW6eF7L+nvCmg9AlcsuP3uG1UMomNFjx1NHAKgqtakDAABAlds49voWAKpTdu3S1rsiYmPqIFDhBq+7tG116hAATJnsP/bM/bOIMHcIAPAGWPIBgARqasz5QJG0z6jfHZ5MB6hKY0VOT6RXALfg+XdJV0t2zyb3TABVKLt2WetdEbEldRAAgEpnyQcAAKaeNR+A6pRdMLd54zntTdE+sz6OHw9Xji8qwtCHrPkAVB2laACAyWPJBwASqVW1hUKZM6t+V1jzAagm2afeNudzEbE7dRBOjyGfynBJV0v2PWs+ANUke3NH0+aXfrL3xZGUWYAyaZ9RnzoCQNVyvAgAAOWxyZoPQNXIxtZGNqUOAlXImg9A9cg+dkX77RGxM3UQAIBqYckHABLStoVi6ZxVvzOs+QBUvKsXl9ZExEOpc3D6zmiuSx2BCeie37LOmg9A5Vu1pHVNnPgMDADAJFHyAQCA8tnc213qW7tlvwMrgArV211adfnZM/4+dQ6ociMfvqztzu8+us89E0Dlyi4/yz0TFM2+Qa/kA5hqSj4AkFhtbU3qCEAZdc1ueDKs+QBUquzc9qbNEeGb6wpTE+65K0131/R//O6j+9wzAVSm7M9+r/PT4Z4JAGDSeUsIAACU15be7lJf6hAATFj2yavm3BIRO1MHgYIY+chlbXemDgHAhGU3LG+/PSK2pQ4CAFCNLPkAQA4Y84FiWXBmw/aw5gNQSbKxssHG1EF4fWrcb1ek7vnT133Hmg9AJcmuWdJ6d5z4vAsAwBSw5AMAAOW3daU1H4BK8dJh1Y9TB4ECGrXmA1A5xlZrH0idAwCgmlnyAYCcqPV4MRTKwlLjtrDmA5B7Kx1WVTz32ZXNmg9Axcgumtey/pW/8MKR0VRZgDKZ2ViXOgJA4Sj5AABAGttWdpf67t+y34EVQE71dpdWXXrWjId++9dHj6VIw+tV69yh0o1+9PL2O779yN5/SB0EgJPKPv32Of9tRPSnDgIAUO2UfAAgRzxkDMVyVmvj1rDmA5BX2QVzmzdGxGDqIFB0l3S1ZOGeCSCvshuWt98eEZtTBwEAKILa1AEAAKDAto+9BgaAfMlu/r3OT0fE7tRBgIgYW/NJHQKA35Fdu7T1rjhRxAQAoAws+QBAztSa84FCWdTW9NPwZDpAnmSfvGrOLRGxLXUQJofb6+rQPb8l+/Yj7pkA8mTl4lJfRDyYOgcAQJEo+QAAQFo7Vi4u9d3/xH4HVgDpvfS6iY2pgwC/Y/T6y9vv+NYje28LRR+A5Hq7S6uuXDTz71LnAMrr4NBo6ggAhafkAwA5VOtpYyiUc9qaNoc1H4DUsmuXed0E5Ny6iLgtdQgAIrtgbvPGiHDaDwBQZko+AACQ3k5rPgBJZdcsab07vG6i6vzrM4dTR2CSWfMBSC67+fc6Px0Ru1MHAQAoIiUfAMipOnM+UCjndTRvCms+AClkVy8urYmIB1IHAU6LNR+AdLJPXjXnlojYljoIAEBR1aYOAAAARETErrFDZgDKaOXiUl9ErE2dgylS46rG6/rl7XeEV+sBlFt2w/L22yNiY+ogAABFZskHAHLMlg8Uy3kdzY+GNR+AsuntLq26ctHMv0udA5gwaz4A5ZV95LK2O0PBEgAgOUs+AACQH7tXLWldkzoEQBH0dpdWLVs4/b9ExGjqLEydHIzOuKboGluTcNgMMPWya5e23hURP04dBAAASz4AkHu1KrlQKOfPadoY1nwAplRvd2nVxfNa1kfEwdRZgNdNwQdg6mXXLGm9OyIeTB0EAIATHBsCAEC+7Bn7EhWAqZG9tbP54YjoTx2EqfUvew5FTU24qvj62BXWfACmUHb14tKaiHggdRAAAH7Dkg8AVIDaqEkdASijt8xptuYDMDWyW97TdUNE7EkdBJgUCj4AUyNbubjUFxFrUwcBAODVLPkAAED+9FvzAZh02V+8e97HI2JX6iDA5LHmAzDpXir43Jc6CAAAv8uSDwBUiFrVXCiUCzubN8Rmaz4AkyT783d13hQRO1MHASadgg/AJFrZreADAJBnSj4AAJBPAx9Y2nr3Dx4fUPIBeGOyz7yz81MRsSN1EMrn53sOeeFtgfzxFe1f+puf7P1KKEcDvCEru0urrnzTzL9LnQMAgJNT8gGAClLjpAIK5cLO5g0R1nwA3oDsz9/VedOx4wo+UOXWpw4AUOGyld2lvhXnzPy748djNHUYAABOzos/AAAgvwauXdp6V+oQABUq++zvz7spLPgUUk1Njatg18ev7PhSeHUXwOuRrVz88iu6FHwAAHLOkg8AVJhacz5QKG+d17IhHh+w5gMwMdlf/P68jx+L2Jk6CFA21nwAJu6VBR8AACqAJR8AAMi3A9cus+YDMAHZ598974ZQ8Cmsf33mcNREuAp43Xhlx61hzQfgdCn4AABUIEs+AFCBamtSJwDK6eJ5LevvfcyaD8BpyL7wB10fGT12fHfqIEASG1IHAKgQ2dWLS2uOR6xNHQQAgImx5AMAAPl38LplbatThwDIs97u0qrb/v38VRGh4AMFZs0H4JSyDyxtvTsUfAAAKpIlHwCoULU15nygSC7uall/z2NhzQfgNfR2l1YtWzj9v4yMHj+YOguQnDUfgJPLPris9a5jx+PB1EEAAHh9LPkAAEBlGPzQpdZ8AH5LtrK7tOrKRTMfiAgFH+IXzx6OmppwFfz6xAprPgCvIfvwZW13Rij4AABUMks+AFDBamtSJwDK6ZKulux7m6z5AIzJVi4u9cXxuC91ECB3rPkAvFp2w/L2248eO64ACQBQ4Sz5AABA5Rgae/ISoOiyVUta10Qo+PBqNS7X2HXTio5bwpoPQERE9smr5vgzEQCgSljyAYAKV1tTkzoCUEbdXdP/8buP7svCmg9QXNm1y1rvGj3mVRPAuDamDgCQA9lnfq/zU4PDx7anDgIAwOSw5AMAAJVl5CPWfIDiysYWzRR8+B3b+w+nn49x5eq66SprPkBx9XaXVn3xD7s+FBEKPgAAVcSSDwBUgVq1XSiUxQumr/uONR+geLKPXdF++8jocQf2wOna2Ntd6lu7Zb97JqBIspWLS33Lz57xwAtDoyOpwwAAMLkcCQIAQOUZvf7y9jvCk+lAcWSfvGqORQ5gwtpmTNsd/uwAiiO7Zknr3RFxX0Qo+AAAVCElHwAAqEzrUgcAKJPsv3nH3D+NiI2pgwAVaWNvd6kvdQiAMsg+cnnbnRHxQOogAABMHa/rAoAq8rPdh1JHAMqkpibihuXtt//txr1fDq/tAqpUb3dp1VvmNG8cHB7dnToL+fZf+4eiJmpSxyCn2mfUv7Tm454JqFbZn7x9zudePDK6KXUQAACmliUfAACoXF49AVSrbGV3adVlZ814KCIUfIA3ypoPULV6u0urbnlP1w0RoeADAFAAlnwAoMrUeIAZCuVjV7Tf/s2fWPMBqkq2aknrmmPHjq9NHYTK4R6YU+mYWb8rrPkA1SVbubjUt/zsGQ88d2h0JHUYAADKw5IPAABUNms+QDXJrru0bXVErE0dBKg6m6z5AFXkpXum+yJCwQcAoEAs+QBAFar1KDMUysev7PjSXz/c/5XwZDpQ2bI/vqL9S0NHj69PHYTKsmPvUOoIVAhrPkCVyD71tjmfOzg06vVcAAAFZMkHAAAqnwNxoNJlf9oz90/Dn2fA1LLmA1SyrLe7tOrWP+z6UEQo+AAAFJQlHwCoUsZ8oFhuXNFx6zc29H81PJkOVJast7vUd1Fny/oDh4/2pw5DZXLfy0TMmWXNB6hI2QeWtt49Mnr8gdRBAABIy5IPAABUhw2pAwBMUHb14tKaiLgvIhR8gHKx5gNUmuxjV7TfHhEKPgAAWPIBgGqmzQvFctOKjlu+vqH/a+HJdCD/suuWta0eHj32UOogVLZf7hsKQz5M1NxZ9TvDmg+Qf1lvd6nvvI6mTc++MLIrdRgAAPLB2R8AAFSPjZ5MBypAduOVHbdGhIIPkMpm90xAzmXXLm29K04sHir4AADwMks+AFDlams92wxF0jGzfld4Mh3Ir+zP39V504FDoztSB6E6HDueOgGVyj0TkGPZJ6+ac8vzh49uTB0EAID8UfIBAIDqsqm3u9S3dst+B1ZAnmQrF5f6Ll0446GBwZHB1GEAImJT6gAAvyVb2V3qu7irJdvz/MhA6jAAAOSTkg8AFECNMR8olDmzPJkO5Er2wWWtdw2PHn8wdRCqyxNP6Yvxxnz4srY7v/voPvdLQB5kH728/Y7BI6PrUgcBACDflHwAAKD6WPMB8iK78cqOWweHRzekDkL1eWtnS+oIVL4NoRgNpJX1dpf63tzRtHnP8yM7U4cBACD/lHwAoCCm1ZrzgSLpmt3wZDi0AhLq7S6telNb008PHDq6I3UWgJMYvG5Z2+p7HrPmAySRXXdp2+qhkWMPpQ4CAEDlUPIBAIDqtGVld6nvfms+QPllq5a0rrn8rBl//+wLIyOpw1Cdho8eSx2BKnHRvOb18ZhiNFBWWW93qe+sUuO2Z18Y2ZY6DAAAlUXJBwAKpHFabeoIQBktamv6aVjzAcor++jl7XccHjm2LnUQgNM0eN2lbavv2WTNBygL6z0AALwhSj4AAFC9dqxa0rrmR5sHHFoB5ZD9ac/cPz1weHRr6iBUv/o65XUmz5L509fds2mfYjQwlbLe7lLfm9qafvr088NeZQoAwOum5AMABTOzyYEIFMlF85r/6UebrfkAUypbubjUt3TB9P/y7MGRg6nDALwOIx+7ov32b/5k75fDPRMw+bKPXNZ25+DwsR+nDgIAQOVzygcAANVt4KOXt98RJ17bBTDZsg9d2rY6Iu6LCAUfoJJlvd2lvtQhgKqSrewurbrlPV03RISCDwAAk8KSDwAAVL91vd2l2Wu37PdkOjCZsv/YM/fP9g8e3ZI6CMXy1HNHUkegCp3RVBdnNNVti7CACEyK7MYrO2597tDRDamDAABQXZR8AKCgDhwaTR0BKJPW6dOidfo0h1bAZHn59VzPeD0XUF22XbOk9e4fbh5wvwS8XtkHlrbevWTB9B/v6B8aSh0GAIDqo+QDAADFsO26ZW2r73lsX4SiD/D6ZR+9vP2OweHRdamDUFxzZjWkjkAVmzOrYd0PNw8oRgMTlfV2l/rObm3cuvvA8PbUYQAAqF61qQMAAABl81Bvd6kvdQigYmU3/17npyNCwQeoZoOfetucz8WJBUSA05HdsLz99oi4LyIUfAAAmFKWfACg4GprUicAyqXzjPqIiK3htV3AxGSrlrSuufysGX+/+/nhkdRhAMpgk9d2Aachu3ZZ612L509f96/PHPZqLgAAykLJBwAAimX79Ze33/GtR/beFoo+wKllN17ZcevzQ6MbUgeBl9TXaakztc5tb4pojwePHju+au2W/T9KnQfInWxld6nvzR1Nm/5t/5FdqcMAAFAsSj4AAFA8665eXJp13xP7lXyAk8lWdpf6LuxsfnjP8yN7UocBSGD07FKjBUTglbLe7lJf56z6nc8cHNmcOgwAAMWk5AMARETEnFn1qSMAZTL2v/e/v++J/Q6tgNeSfejSttVDI8ceSh0EILHt1y9vv+NbGy0gApHdsLz99oNDo1nqIAAAFFtt6gAAAEASI3/+rnk3xYmn0wEiTvx5kN38e52fjggFH4AT1l2zpPXucM8ERZV9+LK299y18qx3hT8HAADIASUfAAAorh03XdVxS/iyGojIPrC09e6IeEdEbEucBSBvHljZXepLHQIoq+zaZa3v/cofLXhvRPw4IkZTBwIAgAiv6wIAgKLb+OHL2u787qP7IryGAooq+5O3z/nc/sGjm1IHgVMZHHbGSvmc0VIXZ7TUvfTT7P4tXnUKBZCtWtK65sK5zRt+0X+4P3UYAAD4bZZ8AACAH3sNBRRStmpJ68o737fwvRGh4AMwvoE/O/E6Q/dLUJ2yqxeXVn7hD7o+EhFrI0LBBwCAXFLyAQAAIiIeuHpxaU04uIKiyD6xouPWOHGINZg4C0Cl2Pbpfzf3vw33S1BNfrvcsztxHgAAGJeSDwAA8JK1K7tLfalDAFMqW7m4tOr2985fFREbUocBqECbb7yy49ZQ9IFKp9wDAEBFmpY6AACQb8ePp04ATJX2GdOifcbvfCR48HjEqrVb9v8oRSZgSmU3Xtlx63OHjyr3ALwxGz52Rfvt3/zJ3i9HRE/qMMCEZNcsab37zR1Nj//i2cOKPQAAVBxLPgAAwCsNXX72jAd7u0urUgcBJk129eLSyr9874LesN4DMFmyG5a33x4WfaBSZNcua33v2P3QA2G5BwCACqXkAwAA/Lahy86a8ZCiD1SF7BMrOm6NE6+hOJA2CkDVya5f3n5HKPpAXmURkX3ksrb3fPX9C/8wIh4M90MAAFQ4JR8AAOC1DCr6QEXLrl5cWvmf/mjB+8J6D8BUWvfxKzu+FIo+kCdZRGRj/9t8R0T8OCKGkiYCAIBJouQDAACczOCKN838u5Unij4OrqByZDdd1XFLnFjvOZg4C0ARrP/kVXNuCfdLkFq2sru06r95x9w/jRPlnvWJ8wAAwKRT8gEAAMYzGhH3Xb24tCYcXEHeZR9Y2vq+/3vvwndHxMbUYQAKZuN/7Jn7Z+F+CVLIrlnS+r4v/EHXRyLivojYmjoQAABMlWmpAwAAABVh7bVLW4fvfXwgIqIndRjgVbLe7lLfwjMbtu05OLItdRiAAtvyhT/o+si2Zw4vX7tl/49Sh4Eql0VEfOTytjsvnNuyYfOvBwdTBwIAgHKw5AMAAJyuB69f3n5HeEId8iT76OXtd8SJp9YVfADS27387BkPet0pTJmst7u06k/ePudzceKVXD+OCAUfAAAKw5IPAAAwEev+5O1zDv4v//Ts/xgWfSCl7OrFpTUXzWv5p1/uOzKQOgwArzIUEfd9cFnr0Pcfs4IIkyT7wNLWu89tb3p82zOHd6cOAwAAqSj5AAAAE7Xplvd03fCLZw9funbL/pvDwRWUU9bbXeo7u9S4dddzR7anDgPAuB78xIqOA3+1of+r4X4JXo+st7vUd2bLtP4L5jY//OivXhxNHQgAAFJT8gEAAF6PXRGxa9WS1mM/2uwJdSiDLCLiEys6bh0YPLohdRgATtuGz7973g3b+4eUo+H0ZVcvLq05u7Vp6y/3De1IHQYAAPKkNnUAAACgoq29/vL2O2KsgABMiezDl7XdGRHviAgFH4DKsysi7rt2Wetd4Z4JTiaLiOz65e3v+sofLXhvRKyNCAUfAAD4LUo+AADAG7Xuz9/VeVNvd2lVOLiCyZRds6T1fX/53gW9EfHj1GEAeMMe/NTb5nwu3C/BS7IYu9/57O/PuylOFJrXRcRg0lQAAJBjXtcFAABMhh0RseMDS1tHfvC413fBG5St7C71ndPetPnfBo7sTB0GgEm1afX7F/7hY7sG3/3DzQOfDfdMFFPW213qa5s+bffXN/RvTB0GAAAqiZIPAAAwmR741Nvm7Plf1z/7P4ZDK5iorLe71HdWqXHbrv1HtqUOA8CUGQr3TBRPFhHxwWWtd725vXnT1j2H+lMHAgCASuR1XQAAwGTbtPr9C//wmiWt7wuvo4DTkfV2l1b9ac/cP42I+yJCwQegGDb9D1ef9a5rl7W+N9wzUZ2yiMhWLWld+Zl3dn4qTryO68GIUPABAIDXyZIPAAAwFYYi4oH/69vnPPU//9Oz/4+xX/OUOrxa1ttd6uua3fDk7gPDW1KHASCJ0Yh48C9+f962HXuHlty/Zf/N4Z6Jypet7C71zT2jYef/+//3zObUYQAAoJoo+QAAAFNpc0S847plbX9wz2P7IhxaQcTYwdfCUuO2X3ktFwAn7IyInZ9625xdY6/winDfRGXJertLfaWWac+c0960ZdOvXhxMHQgAAKqRkg8AAFAOD93ynq5t2589fKkn1Cmw7OrFpTXntDdt2dE/tDN1GAByaVNEvOOjl7e/89uP7L0t3DORb1lvd6nvjOa6gUWtTVueeGrwQOpAAABQ7ZR8AACActkVEbs8oU4BZdcsab37LXOaN/78mUP9qcMAUBHWrX7/wg1bdh/quWfTvi+EeybyQ7EHAAASUvIBAADKzRPqFEEWEXHdsrbVF3Y2P/zT3YcOpg4EQMUZioiHvvJHC9b/9OlDPfc+NvD5cN9EGoo9AACQE0o+AABAKuu+8kcLNjq0ospkvd2lvrYZ03Z//Z/7N6YOA0BVGIyIB7/yRwuyf9lz+G3fs+zD1MsiIlZ2l/raZtTvXlhq2PbYrkGFZQAAyAElHwAAIKXBiHjwy/9hwYatTx96+w8eH/hsOLSiMmWrlrSuWdTauGXH3qGdqcMAUJUGI+Khu1ae9V9+9vShnm9t3Hvb2K+7d2IyZBER1yxpvXveGfU7+v7xmW2pAwEAAL9LyQcAAMiDAxHxwG3/fv6Gbc8cXqHsQ4XIIiI+clnbnW+Z27zxiae8kguAshiNiHURse7T/27ukj3PDy9au2X/zeHeiYnLIiI+dGnb6oWlxm1f+z9270odCAAAGJ+SDwAAkCcDEfHAHf9hQfbzPYevvOcxr6Mgl7KVi0t982c3bP9//eMzW1OHAaDQNkfE5v/uPV0bn9w3tHSsKB3h/onXlkVEXL24tGbOrIZfdZ1Rv/1LD/x6MHUoAADg9Cn5AAAAeXQwIh5a/f6F2b/sObzi2494HQXJZRER1y9vv+O8jqZNj/960GoPAHmye+x64FNvm3Np/wsjC637EGP3L73dpb5ZTXUD889s2P7V/7x7T+pQAADA66fkAwAA5NlQjL2O4k/ePufSZw86sKKssoiIa5e23rWorWmrV1gAUCE2RcSm2987P/vl3iPd31KWLpKXSz0tDbUvzJ3VsPN/+oend6QOBQAATB4lHwAAoFJsiohNf/HueZt37jty0Q83D3w2HFYx+bKIiGuWtN69sNSw7X/6hz0OxgCoVAMxVpb+4h92de4cOHLRdx/d98Wxv+ceqjoo9QAAQMEo+QAAAJVmZ0Ts/FrvWf/5F88evmz/oaNzrfvwBr1c7Jk/u+EXa/7PPdtTBwKASbZn7Prxbf9+fuuv9h+56PnDo63uoSpOFhGxsrvUN6u5bqBjZv2u/+HHT+9MHQoAACgfJR8AAKBSjUTEhoiIW97TtenfBoYu+v5jA58f+3sOqziVLCJi1ZLWNfNnN/zi//l/7tmWOhAAlMlAjP3/4Or3L3zwqQPD5z9zcGTRjzYPfGbs77uPyofspb/4wNLWuztm1u/qmFn/q9v/918fSJgJAABITMkHAACoBrvGrgf/7Pc6L3jqwPD5Dqp4DVlExIcubVu9sNS47Wv/x+5dqQMBQGJDEbFl7Fr73/9f5nfsOTi8aGDwaNf9T+y/eez3uJeaeq8q9JzZMm1P24xpu7/6n3fvSRkKAADIHyUfAACg2mwbu9be/I65F+x+fkThp9iy3u5SX+v0ac8sOLPx53/5955+B4Bx9I9dERH33f7e+a3PHhxZuO/Fo/N/uHngs6/4fe6pXr8sIqK3u9TXOK1mqHV6/e7W6dP2/Kf/71P9p/o3AgAAKPkAAADV7OXCz2fe2Xne7gPD5//g8ZcPqBxOVacsIuKDy1rv6jyjYUfX7IYn//nJF0ZThwKACjUwdm2OiAciIm55T9fCgRdHOp87PNr5iiJ1hHurV3p5mae3u9TXMK1maHbztP7ZzXX9Z7ZM6//C3+0aShkOAACoXEo+AABAUWwfux744h92de7aP3zBC0dGZ6/dsv/mcChVybKIiGuWtN49Z1b9rrmz6nf+9w/8+mDqUABQxV56TWpExNqIiNvfO7/1+UOjrQcOH+04ODTadt8T+z/zit9frfdZryryNE2rHZzZVHdgVnPdwMzGun3WAwEAgKmg5AMAABTRnrEr7lp51t89/fzwOU8/P3zuvY8NfH7s71frYVQ1yCIiPrC09e45M+t3zplVv0upBwCSe2nxZ/vYz9dGRHyt96z6F4+MnvnikdHZLxwZPXPwyLHZh0eOTR8rWf+2PNx/Zb/9C73dpb5ptTUjLQ21B6c31B6c3lh34MRf1x28Ze2vRlKEBAAAikvJBwAAKLrR+M3Kz4N3vm/h9GcPDi985oWRRa8o/UTk4+CpaLKIE4drs5rqBjpm1u9qn1H/lAM1AKgYIxHRP3a90n2v/Ml/+qMFs46MHG86Mnps+vDR403DR481HTl6vHnk2PGmkdHj9ceOHa8bHj3eFBFxkoLQSfV2l/oiImpr4ti0uprhxrraoWl1NcN1tTHSOK12aFptzXDDtJqhpmm1g031tYNf/P/sGnwD/7wAAABTSskHAADg1QYjYtvY9WBExC3v6Vq494WR+c8dPjr3/idePlhS+plcLxd6pjfWvtA2vf6pthnTdlvpAYBCODh2nY77Tv1bAAAAqpOSDwAAwKntGrsiIu776vsXNu0fPNq5/9DRzgOHjnbc98T+z7zi9yr/jO/l12Bcs6T17tnNdf1nTp/Wf2bLtD23/t2uoZTBAAAAAADyTMkHAABg4oYiYufYFRGxNiLi9vfOb33+0GjrgcNHOw4OjbYVuPzzcpGnt7vUN72h9oVZzdP2zW6u6z+jua7/v1u7y+u2AAAAAAAmSMkHAABg8gyMXdvHfr42IuKulWfVvTA02vrC0Ojsg0dG2w4dOTZz6Oix6Wu3vPzqr5dUQhEoe+VPertLfc31tYMzGusOTG+sfW5GY92BGY21zynyAAAAAABMLiUfAACAqTcaEf1j1/ZX/Pp9L/3F6vcvbBo6emz60Mjx6UMjx6YfHjk2/cjRY9OHjx5vGhk93nD02PH61ygFTare7lJfTU1EfV3NUGNd7VB9Xc1Q47Saw431tYPN9bWDjdNO/Osta3+lwAMAAAAAUGY1x48fT50BAAAAAAAAAAAYR23qAAAAAAAAAAAAwPiUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOeUfAAAAAAAAAAAIOf+/0Mh4g/cTZS7AAAAAElFTkSuQmCC" type="image/x-icon" id="logo-icon">

       <link rel="stylesheet" type="text/css" href="../../css/profile-theme.css"> <script src="../../assets/vendor/jquery/jquery.min.js"></script> <script src="../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script> <script src="../../assets/vendor/bootstrap/js/bootstrap.js"></script> <script src="../../assets/vendor/nanoscroller/nanoscroller.js"></script>
      <script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
      <script src="../../assets/vendor/magnific-popup/magnific-popup.js"></script>
      <script src="../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
      <!-- Theme CSS -->
      <link rel="stylesheet" href="../../assets/stylesheets/theme.css" />
      <!-- Skin CSS -->
      <link rel="stylesheet" href="../../assets/stylesheets/skins/default.css" />
      <!-- Theme Custom CSS -->
      <link rel="stylesheet" href="../../assets/stylesheets/theme-custom.css">
      <!-- Head Libs -->
      <script src="../../assets/vendor/modernizr/modernizr.js"></script>
      <script src="../../Functions/lista.js"></script>
      <!-- JavaScript Functions -->
	   <script src="../../Functions/enviar_dados.js"></script>
      <script src="../../Functions/mascara.js"></script>
      <script>
         function alterardate(data)
         {
         	var date=data.split("-");
         	return date[2]+"/"+date[1]+"/"+date[0];
         }
         function excluirimg(id)
            {
               $("#excluirimg").modal('show');
               $('input[name="id_documento"]').val(id);
            }
         function editimg(id,descricao)
            {
               $('#teste').val(descricao).prop('selected', true);
               $('input[name="id_documento"]').val(id);
               $("#editimg").modal('show');
            }
         $(function(){
         	var interno= <?php echo $_SESSION['atendido']?>;
            var endereco=[];
            console.log(interno);
            $.each(endereco,function(i,item){
               $("#cep").text("CEP: "+item.cep);
               $("#cidade").text("Cidade: "+item.cidade);
               $("#bairro").text("Bairro: "+item.bairro);
               $("#logradouro").text("Logradouro: "+item.logradouro);
               $("#numero").text("Numero: "+item.numero_endereco);
               $("#complemento").text("Complemento: "+item.complemento);
            });
         	$.each(interno,function(i,item){
         		if(i=1)
         		{
                  $("#formulario").append($("<input type='hidden' name='idatendido' value='"+item.id+"'>"));
         			var cpf=item.cpf;
         			$("#nome").text("Nome: "+item.nome+' '+item.sobrenome);
         			$("#nome").val(item.nome);
                  $("#sobrenome").val(item.sobrenome);
         			if(item.imagem!=""){
                     $("#imagem").attr("src","data:image/gif;base64,"+item.imagem);
                  }else{
                     $("#imagem").attr("src","../../img/semfoto.png");
                  }
         			if(item.sexo=="m")
         			{
         				$("#sexo").html("Sexo: <i class='fa fa-male'></i>  Masculino");
         				$("#radioM").prop('checked',true);
         			}
         			else if(item.sexo=="f")
         			{
         				$("#sexo").html("Sexo: <i class='fa fa-female'>  Feminino");
         				$("#radioF").prop('checked',true);
         			}
         			$("#pai").text("Nome do pai: "+item.nome_pai);
         			$("#paiform").val(item.nome_pai);
         
         			$("#mae").text("Nome da mãe: "+item.nome_mae);
         			$("#maeform").val(item.nome_mae);
         
         			$("#telefone").text("Telefone:"+item.telefone);
         			$("#telefone").val(item.telefone);
         
         
         			$("#sangueSelect").text(item.tipo_sanguineo);
         			$("#sangueSelect").val(item.tipo_sanguineo);
         			
         			$("#nascimento").text("Data de nascimento: "+alterardate(item.data_nascimento));
         			$("#nascimento").val(item.data_nascimento);
         
         			$("#rg").text("Registro geral: "+item.registro_geral);
         			$("#rg").val(item.registro_geral);
                  
                  if(item.data_expedicao=="0000-00-00")
                  {
                     $("#data_expedicao").text("Data de expedição: Não informado");
                  }
                  else{
                     $("#data_expedicao").text("Data de expedição: "+item.data_expedicao);     
                  }
                  $("#expedicao").val(item.data_expedicao);
         
         			$('#orgao').text("Orgão emissor: "+item.orgao_emissor);
         			$("#orgaoform").val(item.orgao_emissor);
                  if(item.cpf.indexOf("ni")!=-1)
                  {
                     $("#cpf").text("Não informado");
                     $("#cpf").val("Não informado");
                  }
                  else
                  {
                     $("#cpf").text(item.cpf);
                     $("#cpf").val(item.cpf);
                  }
         
         			$("#inss").text("INSS: "+item.inss);
         
         			$("#loas").text("LOAS: "+item.loas);
         
         			$("#funrural").text("FUNRURAL: "+item.funrural);
         
         			$("#certidao").text("Certidão de nascimento: "+item.certidao);
         
         			$("#casamento").text("Certidão de Casamento: "+item.casamento);
         
         			$("#curatela").text("Curatela: "+item.curatela);
         
         			$("#saf").text("SAF: "+item.saf);
         
         			$("#sus").text("SUS: "+item.sus);
         
         			$("#bpc").text("BPC: "+item.bpc);
         
         			$("#ctps").text("CTPS: "+item.ctps);
         
         			$("#titulo").text("Titulo de eleitor: "+item.titulo);
                  
                  $("#observacao").text("Observações: "+item.observacao);
                  $("#observacaoform").val(item.observacao);
         		}
               if(item.imgdoc==null)
               {
                  $('#docs').append($("<strong >").append($("<p >").text("Não foi possível encontrar nenhuma imagem referente a esse Atendido!")));
               }
               else{
                  b64 = item.imgdoc;
                  b64 = b64.replace("data:image/pdf;base64,", "");
                  b64 = b64.replace("data:image/png;base64,", "");
                  b64 = b64.replace("data:image/jpg;base64,", "");
                  b64 = b64.replace("data:image/jpeg;base64,", "");
                  console.log(b64);
               if(b64.charAt(0) == "/" || b64.charAt(0) == "i"){
                  $('#docs').append($("<strong >").append($("<p >").text(item.descricao).attr("class","col-md-8"))).append($("<a >").attr("onclick","excluirimg("+item.id_documento+")").attr("class","link").append($("<i >").attr("class","fa fa-trash col-md-1 pull-right icones"))).append($("<a >").attr("onclick","editimg("+item.id_documento+",'"+item.descricao+"')").attr("class","link").append($("<i >").attr("class","fa fa-edit col-md-1 pull-right icones"))).append($("<div>").append($("<img />").attr("src", item.imgdoc).addClass("lazyload").attr("max-height","50px"))).append($("<form method='get' action='"+ item.imgdoc+"'><button type='submit'>Download</button></form>"));
               }else{
                  $('#docs').append($("<strong >").append($("<p >").text(item.descricao).attr("class","col-md-8"))).append($("<a >").attr("onclick","excluirimg("+item.id_documento+")").attr("class","link").append($("<i >").attr("class","fa fa-trash col-md-1 pull-right icones"))).append($("<a >").attr("onclick","editimg("+item.id_documento+",'"+item.descricao+"')").attr("class","link").append($("<i >").attr("class","fa fa-edit col-md-1 pull-right icones"))).append($("<div>").append($( `<a href="data:application/pdf;base64,${b64}" download="${item.descricao}.pdf"><button type='submit'>Download</button></a>`)));
               }
            }
         	})
         });
         $(function () {
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");
         });
      </script>
      <script type="text/javascript">
      function editar_informacoes_pessoais() {
         $("#nome").prop('disabled', false);
         $("#sobrenome").prop('disabled', false);
         $("#radioM").prop('disabled', false);
         $("#radioF").prop('disabled', false);
         $("#telefone").prop('disabled', false);
        
         $("#nascimento").prop('disabled', false);
         $("#pai").prop('disabled', false);
         $("#mae").prop('disabled', false);
         $("#sangue").prop('disabled', false);
         $("#sangueSelect").remove();
         $('#sangue').append('<option selected >Selecionar...</option>');
         $("#botaoEditarIP").html('Cancelar');
         $("#botaoSalvarIP").prop('disabled', false);
         $("#botaoEditarIP").removeAttr('onclick');
         $("#botaoEditarIP").attr('onclick', "return cancelar_informacoes_pessoais()");
    }
    function editar_documentacao() {

$("#rg").prop('disabled', false);
$("#orgao_emissor").prop('disabled', false);
$("#data_expedicao").prop('disabled', false);
$("#cpf").prop('disabled', false);
$("#data_admissao").prop('disabled', false);

$("#botaoEditarDocumentacao").html('Cancelar');
$("#botaoSalvarDocumentacao").prop('disabled', false);
$("#botaoEditarDocumentacao").removeAttr('onclick');
$("#botaoEditarDocumentacao").attr('onclick', "return cancelar_documentacao()");

}

function cancelar_documentacao() {

$("#rg").prop('disabled', true);
$("#orgao_emissor").prop('disabled', true);
$("#data_expedicao").prop('disabled', true);
$("#cpf").prop('disabled', true);
$("#data_admissao").prop('disabled', true);

$("#botaoEditarDocumentacao").html('Editar');
$("#botaoSalvarDocumentacao").prop('disabled', true);
$("#botaoEditarDocumentacao").removeAttr('onclick');
$("#botaoEditarDocumentacao").attr('onclick', "return editar_documentacao()");

}
      $(function () {
         $("#header").load("header.php");
         $(".menuu").load("menu.php");
          $("#cep").prop('disabled', true);
          $("#uf").prop('disabled', true);
          $("#cidade").prop('disabled', true);
          $("#bairro").prop('disabled', true);
          $("#rua").prop('disabled', true);
          $("#numero_residencia").prop('disabled', true);
          $("#complemento").prop('disabled', true);
          $("#ibge").prop('disabled', true);
         var endereco = [] ;
         if(endereco=="")
         {
            $("#metodo").val("incluirEndereco");
         }
         else
         {
            $("#metodo").val("alterarEndereco");
         }
         $.each(endereco,function(i,item){   
            console.log(endereco);
              $("#nome").val(item.nome).prop('disabled', true);
              $("#cep").val(item.cep).prop('disabled', true);
              $("#uf").val(item.estado).prop('disabled', true);
              $("#cidade").val(item.cidade).prop('disabled', true);
              $("#bairro").val(item.bairro).prop('disabled', true);
              $("#rua").val(item.logradouro).prop('disabled', true);
              $("#numero_residencia").val(item.numero_endereco).prop('disabled', true);
              $("#complemento").val(item.complemento).prop('disabled', true);
              $("#ibge").val(item.ibge).prop('disabled', true);
              if (item.numero_endereco=='Sem número' || item.numero_endereco==null ) {
                $("#numResidencial").prop('checked',true);
              }
              });
       });  
       function editar_endereco(){
         
            $("#nome").prop('disabled', false);
            $("#cep").prop('disabled', false);
            $("#uf").prop('disabled', false);
            $("#cidade").prop('disabled', false);
            $("#bairro").prop('disabled', false);
            $("#rua").prop('disabled', false);
            $("#complemento").prop('disabled', false);
            $("#ibge").prop('disabled', false);         
            $("#numResidencial").prop('disabled', false);
            $("#numero_residencia").prop('disabled', false)
            $("#botaoEditarEndereco").html('Cancelar');
            $("#botaoSalvarEndereco").prop('disabled', false);
            $("#botaoEditarEndereco").removeAttr('onclick');
            $("#botaoEditarEndereco").attr('onclick', "return cancelar_endereco()");
        }
        function numero_residencial()
        {
         if($("#numResidencial").prop('checked'))
         {
            document.getElementById("numero_residencia").readOnly=true;
         }
         else
         {
            document.getElementById("numero_residencia").readOnly=false;
         }
        }
        function cancelar_endereco(){
            $("#cep").prop('disabled', true);
            $("#uf").prop('disabled', true);
            $("#cidade").prop('disabled', true);
            $("#bairro").prop('disabled', true);
            $("#rua").prop('disabled', true);
            $("#complemento").prop('disabled', true);
            $("#ibge").prop('disabled', true);
            $("#numResidencial").prop('disabled', true);
            $("#numero_residencia").prop('disabled', true);
         
            $("#botaoEditarEndereco").html('Editar');
            $("#botaoSalvarEndereco").prop('disabled', true);
            $("#botaoEditarEndereco").removeAttr('onclick');
            $("#botaoEditarEndereco").attr('onclick', "return editar_endereco()");
         
          }
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            document.getElementById('ibge').value=("");
          }
        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value=(conteudo.logradouro);
                document.getElementById('bairro').value=(conteudo.bairro);
                document.getElementById('cidade').value=(conteudo.localidade);
                document.getElementById('uf').value=(conteudo.uf);
                document.getElementById('ibge').value=(conteudo.ibge);
            }
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
          }
        function pesquisacep(valor) {
            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');
       
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
       
              //Expressão regular para validar o CEP.
              var validacep = /^[0-9]{8}$/;
     
              //Valida o formato do CEP.
              if(validacep.test(cep)) {
     
                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                document.getElementById('ibge').value="...";
   
                //Cria um elemento javascript.
                var script = document.createElement('script');
   
                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
   
                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);
     
              } //end if.
              else {
                  //cep é inválido.
                  limpa_formulário_cep();
                  alert("Formato de CEP inválido.");
              }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
         
          };
          function gerarDocFuncional() {
      url = '../../funcionario/documento_listar.php';
      $.ajax({
        data: '',
        type: "POST",
        url: url,
        async: true,
        success: function(response) {
          var documento = response;
          $('#tipoDocumento').empty();
          $('#tipoDocumento').append('<option selected disabled>Selecionar...</option>');
          $.each(documento, function(i, item) {
            $('#tipoDocumento').append('<option value="' + item.id_docfuncional + '">' + item.nome_docfuncional + '</option>');
          });
        },
        dataType: 'json'
      });
    }
    function adicionarDocFuncional() {
      url = '././funcionario/documento_adicionar.php';
      var nome_docfuncional = window.prompt("Cadastre um novo tipo de Documento:");
      if (!nome_docfuncional) {
        return
      }
      nome_docfuncional = nome_docfuncional.trim();
      if (nome_docfuncional == '') {
        return
      }
      data = 'nome_docfuncional=' + nome_docfuncional;
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
          gerarDocFuncional();
        },
        dataType: 'text'
      })
    }
               function listarFunDocs(docfuncional){
               $("#doc-tab").empty();
               $.each(docfuncional, function(i, item) {
                 $("#doc-tab")
                   .append($("<tr>")
                     .append($("<td>").text(item.nome_docfuncional))
                     .append($("<td>").text(item.data))
                     .append($("<td style='display: flex; justify-content: space-evenly;'>")
                       .append($("<a href='./funcionario/documento_download.php?id_doc=" + item.id_fundocs + "' title='Visualizar ou Baixar'><button class='btn btn-primary'><i class='fas fa-download'></i></button></a>"))
                       .append($("<a onclick='removerFuncionarioDocs("+item.id_fundocs+")' href='#' title='Excluir'><button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></a>"))
                     )
                   )
               });
             }
             $(function() {
               $('#datatable-docfuncional').DataTable({
                 "order": [
                   [0, "asc"]
                 ]
               });
             });
    </script>
    <script src="controller/script/valida_cpf_cnpj.js"></script>
   </head>
   <body>
      <section class="body">
         <div id="header"></div>
            <!-- end: header -->
            <div class="inner-wrapper">
               <!-- start: sidebar -->
               <aside id="sidebar-left" class="sidebar-left menuu"></aside>
         <!-- end: sidebar -->
         <section role="main" class="content-body">
            <header class="page-header">
               <h2>Informações paciente</h2>
               <div class="right-wrapper pull-right">
                  <ol class="breadcrumbs">
                     <li>
                        <a href="../index.php">
                        <i class="fa fa-home"></i>
                        </a>
                     </li>
                     <li><span>Informações paciente</span></li>
                  </ol>
                  <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
               </div>
            </header>
            <!-- start: page -->
            <div class="row">
            <div class="col-md-4 col-lg-3">
               <section class="panel">
                        <div class="panel-body">
                                                            <div class="alert alert-warning" style="font-size: 15px;"><i class="fas fa-check mr-md"></i>O endereço da instituição não está cadastrado no sistema<br><a href=https://demo.wegia.org/html/personalizacao.php>Cadastrar endereço da instituição</a></div>
                                                      <div class="thumb-info mb-md">
                                                            <img id="imagem" alt="John Doe">
                                                            <i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
                              <div class="container">
                                 <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                       <!-- Modal content-->
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             <h4 class="modal-title">Adicionar uma Foto</h4>
                                          </div>
                                          <div class="modal-body">
                                             <form class="form-horizontal" method="POST" action="../../controle/control.php" enctype="multipart/form-data">
                                                <input type="hidden" name="nomeClasse" value="AtendidoControle">
                                                <input type="hidden" name="metodo" value="alterarImagem">
                                                <div class="form-group">
                                                   <label class="col-md-4 control-label" for="imgperfil">Carregue nova imagem de perfil:</label>
                                                   <div class="col-md-8">
                                                      <input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
                                                   </div>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                          <input type="hidden" name="idatendido" value= >
                                          <input type="submit" id="formsubmit" value="Alterar imagem">
                                          </div>
                                       </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="widget-toggle-expand mb-md">
                              <div class="widget-header">
                                 <div class="widget-content-expanded">
                                    <ul class="simple-todo-list">
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
               </section>
            </div>
            <div class="col-md-8 col-lg-8">
            <div class="tabs">
            <ul class="nav nav-tabs tabs-primary">
               <li class="active">
                  <a href="#overview" data-toggle="tab">Informações Pessoais</a>
               </li>
               <li>
                  <a href="#cadastro_comorbidades" data-toggle="tab">Cadastro de comorbidades</a>
                </li>
                <li>
                  <a href="#cadastro_exames" data-toggle="tab">Cadastro de exames</a>
               </li>
               <li>
                  <a href="#atendimento_medico" data-toggle="tab">Atendimento médico</a>
               </li>
               <li>
                  <a href="#atendimento_enfermeiro" data-toggle="tab">Atendimento enfermeiro</a>
               </li>
            </ul>
          
            <div class="tab-content">
                <div id="overview" class="tab-pane active">
                  <form class="form-horizontal" method="post" action="../../controle/control.php">
                    <input type="hidden" name="nomeClasse" value="AtendidoControle">
                    <input type="hidden" name="metodo" value="alterarInfPessoal">

                 
                    <section class="panel">
                    <header class="panel-heading">
                    <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    </div>

                    <h2 class="panel-title">Informações pessoais</h2>
                    </header>
                    <div class="panel-body">
                    <hr class="dotted short">

                    <fieldset>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">Nome</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" disabled name="nome" id="nome" onkeypress="return Onlychars(event)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileLastName">Sexo</label>
                        <div class="col-md-8">
                          <label><input type="radio" name="gender" id="radioM" id="M" disabled value="m" style="margin-top: 10px; margin-left: 15px;" onclick="return exibir_reservista()"> <i class="fa fa-male" style="font-size: 20px;"> </i></label>
                          <label><input type="radio" name="gender" id="radioF" disabled id="F" value="f" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_reservista()"> <i class="fa fa-female" style="font-size: 20px;"> </i> </label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileCompany">Nascimento</label>
                        <div class="col-md-8">
                          <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" disabled id="nascimento" max=<?php echo date('Y-m-d'); ?>>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Tipo sanguíneo</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="sangue" id="sangue" disabled>
                            <option selected id="sangueSelect">Não informado</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                          </select>
                        </div>
                      </div>
                      <!--<input type="hidden" name="idatendido" value=<?php echo $_GET['idatendido'] ?>>
                      <button type="button" class="btn btn-primary" id="botaoEditarIP" onclick="return editar_informacoes_pessoais()">Editar</button>-->
                      <!--<input type="submit" class="btn btn-primary" value="Salvar" id="botaoSalvarIP">-->
                      </section>
                   </div>
                  </form>
<!-- Aba  de  comorbidades -->

   <div id="cadastro_comorbidades" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>
                      

                      <h2 class="panel-title">Cadastro de comorbidades</h2>
                    </header>
                  <div class="panel-body">
                    <!--Cadastro de comorbidades-->
                   <hr class="dotted short">
                    <form id="endereco" class="form-horizontal" method="post" action="../../controle/control.php">
                      <input type="hidden" name="nomeClasse" value="EnderecoControle">
                      <input type="hidden" name="metodo" value="alterarEndereco">
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Doenças:</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                            <option selected id="sangueSelect">Selecionar</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                          </select>
                        </div>
                      </div>
                     <div class="form-group center">
                     <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>>
                      <button type="button" class="btn btn-primary" id="botaoEditarEndereco" onclick="return editar_endereco()">Cadastrar</button>
                      <!--<input id="botaoSalvarEndereco" type="submit" class="btn btn-primary" disabled="true" value="Salvar" onclick="funcao3()">-->
                    </form>
                  </div>
                  
                  </section>
         </div>



         <!-- Aba de exames -->
            <div id="cadastro_exames" class="tab-pane">
                 <section class="panel">
                   <header class="panel-heading">
                     <div class="panel-actions">
                       <a href="#" class="fa fa-caret-down"></a>
                     </div>
                     
                     <h2 class="panel-title">Exames</h2>

                     </header>
                     <div class="panel-body">
                 <form class="form-horizontal" method="post" action="../controle/control.php">
                   <input type="hidden" name="nomeClasse" value="AtendidoControle">
                   <input type="hidden" name="metodo" value="alterarDocumentacao">
                   <!--<div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Upload de arquivo</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="rg" id="rg">
                     </div>-->
                     
                   
                      <div class="modal fade" id="docFormModal" tabindex="-1" role="dialog" aria-labelledby="docFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header" style="display: flex;justify-content: space-between;">
                              <h5 class="modal-title" id="exampleModalLabel">Adicionar Arquivo</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action='./funcionario/documento_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'>
                              <div class="modal-body" style="padding: 15px 40px">
                                <div class="form-group" style="display: grid;">
                                  <label class="my-1 mr-2" for="tipoDocumento">Tipo de Arquivo</label><br>
                                  <div style="display: flex;">
                                    <select name="id_docfuncional" class="custom-select my-1 mr-sm-2" id="tipoDocumento" required>
                                      <option selected disabled>Selecionar...</option>
                                      <option value="Certidão de Nascimento">Certidão de Nascimento</option>
                                       <option value="Certidão de Casamento">Certidão de Casamento</option>
                                       <option value="Curatela">Curatela</option>
                                       <option value="INSS">INSS</option>
                                       <option value="LOAS">LOAS</option>
                                       <option value="FUNRURAL">FUNRURAL</option>
                                       <option value="Título de Eleitor">Título de Eleitor</option>
                                       <option value="CTPS">CTPS</option>
                                       <option value="SAF">SAF</option>
                                       <option value="SUS">SUS</option>
                                       <option value="BPC">BPC</option> 
                                       <option value="CPF">CPF</option>
                                       <option value="Registro Geral">RG</option>
                                      
                                    
                                    </select>
                                   
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="arquivoDocumento">Arquivo</label>
                                  <input name="arquivo" type="file" class="form-control-file" id="id_documento" accept="png;jpeg;jpg;pdf;docx;doc;odp" required>
                                </div>
                                <input type="number" name="id_interno" value="" style='display: none;'>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input type="submit" value="Enviar" class="btn btn-primary">
                              </div>
                            </form>
                            </div>
                          </div>
                        </div>
                        <br />
                   <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Tipo exame:</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                            <option selected id="sangueSelect">Selecionar</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                          </select>
                        </div>
            </div>
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Data do exame</label>
                     <div class="col-md-6">
                       <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" name="data_expedicao" id="data_expedicao" max=2021-06-11>
                     </div>
                   </div>
                   <!--
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany"></label>
                     <div class="col-md-6">
                       <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                     </div>
                   </div>
                  -->     

                   <div class="panel-body">
                   
                     <br>
                     <br>
                      <table class="table table-bordered table-striped mb-none" id="datatable-docfuncional">
                        <thead>
                          <tr>
                            <th>Arquivo</th>
                            <th>Tipo exame</th>
                            <th>Data exame</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="doc-tab">
                        </tbody>
                      </table>
                      <br>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docFormModal">
                        Adicionar
                      </button>
                      <!-- Modal Form Documentos -->
                      <div class="modal fade" id="docFormModal" tabindex="-1" role="dialog" aria-labelledby="docFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header" style="display: flex;justify-content: space-between;">
                              <h5 class="modal-title" id="exampleModalLabel">Adicionar Arquivo</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action='./funcionario/documento_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'>
                              <div class="modal-body" style="padding: 15px 40px">
                                <div class="form-group" style="display: grid;">
                                  <label class="my-1 mr-2" for="tipoDocumento">Tipo de Arquivo</label><br>
                                  <div style="display: flex;">
                                    <select name="id_docfuncional" class="custom-select my-1 mr-sm-2" id="tipoDocumento" required>
                                      <option selected disabled>Selecionar...</option>
                                      <option value="Certidão de Nascimento">Certidão de Nascimento</option>
                                       <option value="Certidão de Casamento">Certidão de Casamento</option>
                                       <option value="Curatela">Curatela</option>
                                       <option value="INSS">INSS</option>
                                       <option value="LOAS">LOAS</option>
                                       <option value="FUNRURAL">FUNRURAL</option>
                                       <option value="Título de Eleitor">Título de Eleitor</option>
                                       <option value="CTPS">CTPS</option>
                                       <option value="SAF">SAF</option>
                                       <option value="SUS">SUS</option>
                                       <option value="BPC">BPC</option> 
                                       <option value="CPF">CPF</option>
                                       <option value="Registro Geral">RG</option>
                                      
                                    
                                    </select>
                                   <!-- <a onclick="adicionarDocFuncional()" style="margin: 0 20px;"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a> -->
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="arquivoDocumento">Arquivo</label>
                                  <input name="arquivo" type="file" class="form-control-file" id="id_documento" accept="png;jpeg;jpg;pdf;docx;doc;odp" required>
                                </div>
                                <input type="number" name="id_interno" value="" style='display: none;'>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input type="submit" value="Enviar" class="btn btn-primary">
                              </div>
                            </form>
                            </div>
                          </div>
                        </div>
                   
                   <br />
                   <!--<input type="hidden" name="idatendido" value=1>
                   <button type="button" class="btn btn-primary" id="botaoEditarDocumentacao" onclick="return editar_documentacao()">Cadastrar</button>
                   <input id="botaoSalvarDocumentacao" type="submit" class="btn btn-primary" disabled="true" value="Salvar" onclick="funcao3()">-->
                 </form>
            </div>
         </section>
         </div>
       
      <!-- aba de atendimento médico -->
       <div id="atendimento_medico" class="tab-pane">
         <section class="panel">
            <header class="panel-heading">
               <div class="panel-actions">
                  <a href="#" class="fa fa-caret-down"></a>
               </div>

               <h2 class="panel-title">Atendimento médico</h2>
               </header>
               <div class="panel-body">
               <hr class="dotted short">
               <form class="form-horizontal" method="post" action="../controle/control.php">
                   <input type="hidden" name="nomeClasse" value="AtendidoControle">
                   <input type="hidden" name="metodo" value="alterarDocumentacao">

                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Data do atendimento:</label>
                     <div class="col-md-6">
                     <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" name="data_expedicao" id="data_expedicao" max=2021-06-11>
                     </div>
                   </div>
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany"></label>
                     <div class="col-md-6">
                       <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                     </div>
                   </div>
                   <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Médico:</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                            <option selected id="sangueSelect">Selecionar</option>
                            <option value="AB+">Rebeca</option>
                            <option value="AB-">Artur</option>
                            <option value="AB-">Maria Clara</option>
                            <option value="AB-">Luiza</option>
                          </select>
                        </div>
                      </div>
                   <!--
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Médico:</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                     </div>
                   </div>-->
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Descrição:</label>
                       <div class='col-md-6' id='div_texto' style="height: 499px;">
                        <textarea cols='30' rows='3' id='despacho' name='texto' required class='form-control'></textarea>
                        </div>
                     
                      </div>
                     <!--<div class="col-md-6">
                       <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                     </div>
                   </div>-->

            </section>
              <section class="panel">
                   <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                    </div>

                   <h2 class="panel-title">Medicação</h2>
                  </header>
                   <br />
                   
                   <div class="panel-body">
                   <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Remédio:</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                            <option selected id="sangueSelect">Selecionar</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Dose:</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                     </div>
                     </div>
                     <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Horário:</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                     </div>
                   </div>
                   <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Tempo:</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                     </div>
                   </div>

                  
                   <div class="panel-body">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docFormModal">Inserir na tabela</button>
                      <br>
                      <br>
                      <table class="table table-bordered table-striped mb-none" id="datatable-docfuncional">
                        <thead>
                          <tr>
                            <th>Medicação</th>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Nome do médico</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="doc-tab">
                        </tbody>
                      </table>
                      <br>
                      <!-- Modal Form Documentos -->
                      <div class="modal fade" id="docFormModal" tabindex="-1" role="dialog" aria-labelledby="docFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header" style="display: flex;justify-content: space-between;">
                              <h5 class="modal-title" id="exampleModalLabel">Adicionar Arquivo</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action='./funcionario/documento_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'>
                              <div class="modal-body" style="padding: 15px 40px">
                                <div class="form-group" style="display: grid;">
                                  <label class="my-1 mr-2" for="tipoDocumento">Tipo de Arquivo</label><br>
                                  <div style="display: flex;">
                                    <select name="id_docfuncional" class="custom-select my-1 mr-sm-2" id="tipoDocumento" required>
                                      <option selected disabled>Selecionar...</option>
                                      <option value="Certidão de Nascimento">Certidão de Nascimento</option>
                                       <option value="Certidão de Casamento">Certidão de Casamento</option>
                                       <option value="Curatela">Curatela</option>
                                       <option value="INSS">INSS</option>
                                       <option value="LOAS">LOAS</option>
                                       <option value="FUNRURAL">FUNRURAL</option>
                                       <option value="Título de Eleitor">Título de Eleitor</option>
                                       <option value="CTPS">CTPS</option>
                                       <option value="SAF">SAF</option>
                                       <option value="SUS">SUS</option>
                                       <option value="BPC">BPC</option> 
                                       <option value="CPF">CPF</option>
                                       <option value="Registro Geral">RG</option>
                                      
                                    
                                    </select>
                                   <!-- <a onclick="adicionarDocFuncional()" style="margin: 0 20px;"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a> -->
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="arquivoDocumento">Arquivo</label>
                                  <input name="arquivo" type="file" class="form-control-file" id="id_documento" accept="png;jpeg;jpg;pdf;docx;doc;odp" required>
                                </div>
                                <input type="number" name="id_interno" value="" style='display: none;'>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input type="submit" value="Enviar" class="btn btn-primary">
                              </div>
                            </form>
                            </div>
                          </div>
                        </div>
                   
                   <br />
                   <br />
                   <input type="hidden" name="idatendido" value=1>
                   <button type="button" class="btn btn-primary" id="botaoEditarDocumentacao" onclick="return editar_documentacao()">Cadastrar atendimento</button>
                   <!--<input id="botaoSalvarDocumentacao" type="submit" class="btn btn-primary" value="Cadastrar" onclick="funcao3()">-->
                 </form>
            </div>
         </section>
       </div>
      
       
       <!-- aba de atendimento enfermeiro -->
       <div id="atendimento_enfermeiro" class="tab-pane">
         <section class="panel">
            <header class="panel-heading">
               <div class="panel-actions">
                  <a href="#" class="fa fa-caret-down"></a>
               </div>

               <h2 class="panel-title">Atendimento enfermeiro</h2>
            </header>
            <div class="panel-body">
               <form class="form-horizontal" method="post" action="../controle/control.php">
                   <input type="hidden" name="nomeClasse" value="AtendidoControle">
                   <input type="hidden" name="metodo" value="alterarDocumentacao">

                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Data do atendimento:</label>
                     <div class="col-md-6">
                     <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" name="data_expedicao" id="data_expedicao" max=2021-06-11>
                     </div>
                   </div>
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany"></label>
                     <div class="col-md-6">
                       <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                     </div>
                   </div>
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Enfermeiro:</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                     </div>
                   </div>
                   <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">Descrição:</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" disabled name="sobrenome" id="sobrenome" onkeypress="return Onlychars(event)">
                        </div>
                      </div>
                   <br />
                </section>
           
            
                
                <section class="panel">
                   <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                    </div>
                   <h2 class="panel-title">Aplicar medicação</h2>
                </header>
                   
                   <div class="panel-body">
                    <label class="col-md-12 control-label">Informações recuperadas da medicação que o médico forneceu:</label>
                    <br>
                    <table class="table table-bordered table-striped mb-none" id="datatable-docfuncional">
                          <thead>
                            <tr>
                              <th>Remédio</th>
                              <th>Horário</th>
                              <th>Dose</th>
                              <th>Tempo</th>
                            </tr>
                          </thead>
                          <tbody id="doc-tab">
                          </tbody>
                        </table>
                  <br>
                  <br>
                  <br>
                  <div class="form-group">
                     
                        <label class="col-md-3 control-label" for="inputSuccess">Remédio:</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                            <option selected id="sangueSelect">Selecionar</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Horário de aplicação</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                     </div>
                     </div>
                    
                      
                     <br />
                     <input type="hidden" name="idatendido" value=1>
                     <input type="hidden" name="idatendido" value=1>
                     <button type="button" class="btn btn-primary" id="botaoEditarDocumentacao" onclick="return editar_documentacao()">Aplicar medicação</button>

                     <br />
                     <br />


                     <h2 class="panel-title">Aplicações efetuadas</h2>
                     
                     <div class="panel-body">
                    <table class="table table-bordered table-striped mb-none" id="datatable-docfuncional">
                          <thead>
                            <tr>
                              <th>Medicamento</th>
                              <th>Horário de aplicação</th>
                              <th>Ação</th>
                            </tr>
                          </thead>
                          <tbody id="doc-tab">
                          </tbody>
                        </table>
                  <br>
                  <br>
                  <br>
                     
                   
                   <input id="botaoSalvarDocumentacao" type="submit" class="btn btn-primary" value="Cadastrar aplicação desses medicamentos" onclick="funcao3()">
                 </form>
            </div>
         </section>
       </div>  



       
         <aside id="sidebar-right" class="sidebar-right">
            <div class="nano">
               <div class="nano-content">
                  <a href="#" class="mobile-close visible-xs">
                  Collapse <i class="fa fa-chevron-right"></i>
                  </a>
                  <div class="sidebar-right-wrapper">
                     <div class="sidebar-widget widget-calendar">
                        <h6>Upcoming Tasks</h6>
                        <div data-plugin-datepicker data-plugin-skin="dark" ></div>
                        <ul>
                           <li>
                              <time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
                              <span>Company Meeting</span>
                           </li>
                        </ul>
                     </div>
                     <div class="sidebar-widget widget-friends">
                        <h6>Friends</h6>
                        <ul>
                           <li class="status-online">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-online">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-offline">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-offline">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </aside>
      </section>
		<!-- Vendor -->
		<script src="../../assets/vendor/select2/select2.js"></script>
        <script src="../../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="../../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="../../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        <!-- Theme Base, Components and Settings -->
        <script src="../../assets/javascripts/theme.js"></script>
        <!-- Theme Custom -->
        <script src="../../assets/javascripts/theme.custom.js"></script>
        <!-- Theme Initialization Files -->
        <script src="../../assets/javascripts/theme.init.js"></script>
        <!-- Examples -->
        <script src="../../assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="../../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="../../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
         <div class="modal fade" id="excluirimg" role="dialog">
         <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
         <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">×</button>
	      <h3>Excluir um Documento</h3>
         </div>
         <div class="modal-body">
         <p> Tem certeza que deseja excluir a imagem desse documento? Essa ação não poderá ser desfeita! </p>
         <form action="../../controle/control.php" method="GET">
            <input type="hidden" name="id_documento" id="excluirdoc">
            <input type="hidden" name="nomeClasse" value="DocumentoControle">
            <input type="hidden" name="metodo" value="excluir">
            <input type="hidden" name="id" value="">
            <input type="submit" value="Confirmar" class="btn btn-success">
            <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         </form>
         </div>
         </div>
         </div>
         </div>
         <iv class="modal fade" id="editimg" role="dialog">
         <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">×</button>
         <h3>Alterar um Documento</h3>
         </div>
         <div class="modal-body">
         <p> Selecione o benefício referente a nova imagem</p>
         <form action="../../controle/control.php" method="POST" enctype="multipart/form-data">
            <select name="descricao" id="teste">
               <option value="Certidão de Nascimento">Certidão de Nascimento</option>
               <option value="Certidão de Casamento">Certidão de Casamento</option>
               <option value="Curatela">Curatela</option>
               <option value="INSS">INSS</option>
               <option value="LOAS">LOAS</option>
               <option value="FUNRURAL">FUNRURAL</option>
               <option value="Título de Eleitor">Título de Eleitor</option>
               <option value="CTPS">CTPS</option>
               <option value="SAF">SAF</option>
               <option value="SUS">SUS</option>
               <option value="BPC">BPC</option> 
               <option value="CPF">CPF</option>
               <option value="Registro Geral">RG</option>
            </select><br/>
            
            <p> Selecione a nova imagem</p>
            <div class="col-md-12">
               <input type="file" name="doc" size="60"  class="form-control" > 
            </div><br/>
            <input type="hidden" name="id_documento" id="id_documento">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="nomeClasse" value="DocumentoControle">
            <input type="hidden" name="metodo" value="alterar">
            <input type="submit" value="Confirmar" class="btn btn-success">
            <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         </form>
         </div>
         </div>
         </div>
         </div>
         <script>
   function funcao1(){
        var cpfs = [{"cpf":"admin","id":"1"}] ;
        var cpf_atendido = $("#cpf").val();
        var cpf_atendido_correto = cpf_atendido.replace(".", "");
        var cpf_atendido_correto1 = cpf_atendido_correto.replace(".", "");
        var cpf_atendido_correto2 = cpf_atendido_correto1.replace(".", "");
        var cpf_atendido_correto3 = cpf_atendido_correto2.replace("-", "");
        var apoio = 0;
        var cpfs1 = [] ;
        $.each(cpfs,function(i,item){
          if(item.cpf==cpf_atendido_correto3)
          {
            alert("Alteração não realizada! O CPF informado já está cadastrado no sistema");
            apoio = 1;
          }
        });
        $.each(cpfs1,function(i,item){
          if(item.cpf==cpf_atendido_correto3)
          { 
            alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
            apoio = 1;
          }
        });
        if(apoio == 0)
        {
          alert("Cadastrado com sucesso!")
        }
      }
   </script>
   <!-- Vendor -->
   <script src="<?php echo WWW;?>assets/vendor/select2/select2.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        
        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
        <!-- Theme Custom -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
        <!-- Theme Initialization Files -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>
        <!-- Examples -->
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
  </body>
</html> 
