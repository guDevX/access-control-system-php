<?php
// 1. Conexão com o Banco de Dados
$pdo = new PDO("mysql:host=localhost;dbname=academia", "usuario", "senha");

// 2. Recebe o dado do aluno (ex: via formulário ou leitor)
$cpf_aluno = $_POST['cpf']; 

// 3. Consulta a situação financeira
$sql = $pdo->prepare("SELECT status_pagamento FROM alunos WHERE cpf = :cpf");
$sql->execute(['cpf' => $cpf_aluno]);
$aluno = $sql->fetch();

// 4. Verificação de Regras de Negócio
if ($aluno && $aluno['status_pagamento'] == 'EM_DIA') {
    
    // SE ESTIVER PAGO: Executa o código da catraca que vimos antes
    $socket = fsockopen("192.168.1.100", 1001);
    fwrite($socket, "LIBERAR"); 
    fclose($socket);
    
    echo "Acesso Liberado! Bom treino.";

} else {
    // SE NÃO PAGOU OU NÃO EXISTE
    echo "Acesso Negado: Verifique sua mensalidade na recepção.";
}
?>
