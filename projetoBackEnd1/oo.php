<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programação Orientada a Objetos em PHP</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Programação Orientada a Objetos em PHP</h1>
    <?php
    Class Conta {
        public $saldo = 0;
        public $titular;

        function depositar($valor) {
            $this->saldo += $valor;
        }

        function sacar($valor) {
            if (($this->saldo > 0) && ($this->saldo >= $valor)) {
                $this->saldo -= $valor;
            } else {
                echo "Saldo insuficiente!" . "<br>";
            }
        }

        function verSaldo() {
            echo "Saldo atual: R$ " . $this->saldo . "<br>";
        }
    }

    class ContaCorrente extends Conta {
        function transferir($contaDestino, $valor) {
            $this->saldo -= $valor;
        }
    }

    $novaConta = new Conta();
    $novaConta->verSaldo();
    $novaConta->depositar(100);
    $novaConta->verSaldo();
    $novaConta->sacar(1150);
    $novaConta->sacar(50);
    $novaConta->verSaldo();
    
    echo "<br> ContaCorrente <br><br>";

    $novaContaCorrente = new ContaCorrente();
    $novaContaCorrente->depositar(1000);
    $novaContaCorrente->verSaldo();
    $novaContaCorrente->transferir('xxx-xxx', 500);
    echo "Saldo: " . $novaContaCorrente->saldo;
    ?>
</body>
</html>