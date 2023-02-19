<?php 

# precisa subir dois níveis pois a chamada é pelo repo público
require "../../app_lista_tarefas/tarefa.model.php";
require "../../app_lista_tarefas/conexao.php"; 
require "../../app_lista_tarefas/tarefa.service.php";

$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

if($acao == 'inserir') {
    $tarefa = new Tarefa();
    $tarefa->__set('tarefa', $_POST['tarefa']);

    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->inserir();

    // echo '<pre>';
    // print_r($tarefaService);
    // echo '</pre>';
    if(isset($_GET['pag']) && $_GET['pag'] == 'index')
        header('Location: index.php?inclusao=1');
    else
        header('Location: nova_tarefa.php?inclusao=1');

} else if($acao == 'recuperar') {

    $tarefa = new Tarefa();
    $conexao = new Conexao();
    
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefas = $tarefaService->recuperar();

} else if($acao == 'atualizar') {

    $tarefa = new Tarefa();
    /// __set retorna está a retornar a instância do próprio obj
    $tarefa->__set('id', $_POST['id'])
        ->__set('tarefa', $_POST['tarefa']);
    //$tarefa->__set('tarefa', $_POST['tarefa']);

    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);
    $ret = $tarefaService->atualizar();

    if(isset($_GET['pag']) && $_GET['pag'] == 'index')
        header('Location: index.php?atualizado='.$ret);
    else
        header('Location: todas_tarefas.php?atualizado='.$ret);
    

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
} else if($acao == 'remover') {
    $tarefa = new Tarefa();
    $tarefa->__set('id', $_GET['id']);

    $conexao = new Conexao();
    
    $tarefaService = new TarefaService($conexao, $tarefa);
    $ret = $tarefaService->remover();

    if(isset($_GET['pag']) && $_GET['pag'] == 'index')
        header('Location: index.php?deletado='.$ret);
    else
        header('Location: todas_tarefas.php?deletado='.$ret);
} else if($acao == 'marcarRealizada') {
    $tarefa = new Tarefa();
    $tarefa->__set('id', $_GET['id'])
        ->__set('id_status', 2);

    $conexao = new Conexao();
    
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->marcarRealizada();
    
    if(isset($_GET['pag']) && $_GET['pag'] == 'index')
        header('Location: index.php?marcado=1');
    else    
        header('Location: todas_tarefas.php?marcado=1');

} else if($acao == 'recuperarPendentes')
{
    $tarefa = new Tarefa();
    $conexao = new Conexao();
    
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefas = $tarefaService->recuperarPendentes();
}





?>