<?php 

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();

    // if(!isset($_SESSION['saude_id'])){
    //     header ("Location: profile_paciente.php?idsaude=$id");
    // }
   	if(!isset($_SESSION['usuario'])){
   		header ("Location: ../index.php");
   	}

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
  
  /*require_once ROOT."/controle/FuncionarioControle.php";
  $cpf1 = new FuncionarioControle;
  $cpf1->listarCpf();*/

  require_once ROOT."/controle/SaudeControle.php";
  /*$cpf = new AtendidoControle;
  $cpf->listarCpf();*/

  /*require_once ROOT."/controle/EnderecoControle.php";
  $endereco = new EnderecoControle;
  $endereco->listarInstituicao();*/
   
   
   $id=$_GET['id_fichamedica'];
   $cache = new Cache();
   $teste = $cache->read($id);
   //$atendidos = $_SESSION['idatendido'];
   // $atendido = new AtendidoDAO();
   // $atendido->listar($id);
   // var_dump($atendido);
   
  //  if (!isset($teste)) {
   		
  //  		header('Location: ../../controle/control.php?metodo=listarUm&nomeClasse=SaudeControle&nextPage=../html/saude/saude.php?id_fichamedica='.$id.'&id='.$id);
  //     }
   
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

       <link rel="stylesheet" type="text/css" href="../../css/profile-theme.css"> 
      </script> <script src="../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script> <script src="../../assets/vendor/bootstrap/js/bootstrap.js"></script> <script src="../../assets/vendor/nanoscroller/nanoscroller.js"></script>
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
        
         $(function(){
         	var interno= <?php echo $_SESSION['id_fichamedica']?>; // pega no SaudeControle, listarUm
            var endereco=[];
            console.log(interno);
         	$.each(interno,function(i,item){
         		if(i=1)
         		{
              $("#formulario").append($("<input type='hidden' name='id_fichamedica' value='"+item.id+"'>"));
         			//var cpf=item.cpf;
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
         			$("#sangueSelect").text(item.tipo_sanguineo);
         			$("#sangueSelect").val(item.tipo_sanguineo);
         			
         			$("#nascimento").text("Data de nascimento: "+alterardate(item.data_nascimento));
         			$("#nascimento").val(item.data_nascimento);
         
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
         });
         $(function () {
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");
         });
      // </script>
      // <script type="text/javascript">
    //  });
               
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
                                                <input type="hidden" name="nomeClasse" value="SaudeControle">
                                                <input type="hidden" name="metodo" value="alterarImagem">
                                                <div class="form-group">
                                                   <label class="col-md-4 control-label" for="imgperfil">Carregue nova imagem de perfil:</label>
                                                   <div class="col-md-8">
                                                      <input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
                                                   </div>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                          <input type="hidden" name="id_fichamedica" value= >
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
                    <input type="hidden" name="nomeClasse" value="SaudeControle">
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
                      <!--<input type="hidden" name="id_fichamedica" value=<?php echo $_GET['id_fichamedica'] ?>>
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
                     <!--<input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>-->
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
                   <input type="hidden" name="nomeClasse" value="SaudeControle">
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
                   <!--<input type="hidden" name="id_fichamedica" value=1>
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
                   <input type="hidden" name="nomeClasse" value="SaudeControle">
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
                   <input type="hidden" name="id_fichamedica" value=1>
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
                   <input type="hidden" name="nomeClasse" value="SaudeControle">
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
                     <input type="hidden" name="id_fichamedica" value=1>
                     <input type="hidden" name="id_fichamedica" value=1>
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
        <!-- Theme Custom -->
        <script src="../../assets/javascripts/theme.custom.js"></script>
        <!-- Theme Initialization Files -->
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
        
        <!-- Theme Custom -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
        <!-- Theme Initialization Files -->
        <!-- Examples -->
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
  </body>
</html> 