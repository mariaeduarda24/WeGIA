<?php
    include ("conexao.php");
    
    $cod_regras = $_POST['regras_sistema'];
    $id_sistema = $_POST['id_sistema'];
    $MinValUnic = $_POST['minval'];
    $MensalDiasV =$_POST['mensaldiasv'];
    $juros = $_POST['juros'];
    $multa =$_POST['multa'];
    $MaiValParc = $_POST['maivalparc'];
    $MinValParc = $_POST['minvalparc'];
    $agradecimento = $_POST['agradecimento'];
    $UnicDiasV =$_POST['unicdiasv'];
    $opVenc0 = $_POST['op01'];
    $opVenc1 = $_POST['op02'];
    $opVenc2= $_POST['op03'];
    $opVenc3 = $_POST['op04'];
    $opVenc4 = $_POST['op05'];
    $opVenc5 = $_POST['op06'];
    $API = $_POST['api'];
    $token = $_POST['token_api'];
    $sandbox = $_POST['sandbox'];
    $token_sandbox = $_POST['token_sandbox'];

     $atualiza_regras = mysqli_query($conexao, "UPDATE  doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) SET min_boleto_uni = '$MinValUnic', max_dias_venc = '$MensalDiasV', juros = '$juros', multa = '$multa', max_parcela = '$MaiValParc', min_parcela = '$MinValParc', agradecimento = '$agradecimento', dias_boleto_a_vista = '$UnicDiasV', dias_venc_carne_op1 = '$opVenc0', dias_venc_carne_op2 = '$opVenc1', dias_venc_carne_op3 = '$opVenc2', dias_venc_carne_op4 = '$opVenc3', dias_venc_carne_op5 = '$opVenc4', dias_venc_carne_op6 = '$opVenc5', api = '$API', token_api = '$token', sandbox = '$sandbox', token_sandbox = '$token_sandbox' WHERE id_regras = '$cod_regras' AND id_sistema = '$id_sistema'");
   
     
      $cod_cartao = $_POST['cod_cartao'];
      $link_avulso = $_POST['avulso_link'];
      $atualiza_avulso = mysqli_query($conexao, "UPDATE doacao_cartao_avulso SET url = '$link_avulso' WHERE id_sistema = $cod_cartao");


      print_r($link_mensal = $_POST['link_doacao']);
      print_r($valor_mensal = $_POST['valores']);
      $id= $_POST['id'];

    for($i =0; $i<count($valor_mensal); $i++)
    {
          
          mysqli_query($conexao, "UPDATE doacao_cartao_mensal SET  valor = '$valor_mensal[$i]', link = '$link_mensal[$i]' WHERE id = '$id[$i]' AND id_sistema = $cod_cartao");
    }

   header("Location: configuracao_doacao.php");
?>


    


        
  