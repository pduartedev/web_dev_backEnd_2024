<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundamentos de PHP</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Olá Mundo</h1>
    <?php
    echo "Hello World!";
    ?>

    <br><br>

    <h2>Variáveis</h2>
    <?php
    $texto1 = "Exemplo";
    $texto2 = "Esse é o terceiro $texto1 de PHP";
    echo $texto2;
    ?>

    <br><br>


    <h2>Concatenação de conteúdo</h2>
    <?php
    $texto2 = "Para concatenarmos strings, deveremos utilizar o ponto (.)";
    $texto2 .= " antes do sinal de atribuição de variável (=), ficando desta forma: \".=\"";
    echo $texto2;
    ?>

    <br><br>

    <h2>Operadores</h2>
    <?php
    $num1 = 10;
    $num2 = 20;
    $media = ($num1 + $num2) / 2;

    echo "Aqui não haverá problemas, pois os tipos são iguais!";
    echo "<br>";
    echo "Inteiros: \$num1 = $num1 - \$num2 = $num2";
    echo "<br>";
    echo "Média \$media = $media";

    echo "<br><br>";

    $nome = "123";
    echo "\$nome = $nome";
    echo "<br>";
    $soma = $nome + $media;
    echo "\$media = $media";
    echo "<br>";
    echo "Aqui haverá coerção, pois os tipos são diferentes (string e inteiro)!";
    echo "<br>";
    echo "Inteiro: $media.String: $nome";
    echo "<br>";
    echo "Resultado inteiro: $soma";
    echo "<br>";
    ?>

    <br><br>

    <h2>Operadores de INCREMENTO e DENCREMENTO</h2>
    <?php
    $num1 = 10;
    $num2 = 20;
    echo "Valores iniciais de \$num1 = $num1, e \$num2 = $num2";
    echo "<br>";
    $num3 = ++$num1;
    $num4 = $num2++;
    echo "Valores alterados: ";
    echo "<br>";
    echo "\$num1: $num1 - \$num2: $num2";
    echo "<br>";
    echo "\$num3: $num3 - \$num4: $num4";
    ?>

    <br><br>

    <h2>IF e ELSE</h2>
    <?php
    $nome = "Luiz Felipe";
    $sexo = "M";
    $idade = 35;

    if ($sexo == "F" && $idade > 30) {
        echo "Sexo Feminino";
        echo "<br>";
        echo "Maior que 30 anos";
    } else if ($sexo == "M" && $idade < 20) {
        echo "Sexo Masculino";
        echo "<br>";
        echo "Menor que 30 anos";
    } else {
        if (($idade >= 35) or ($sexo == "F")) {
            echo "$nome";
            echo "<br>";
            echo "A idade é igual ou superior a 35 anos";
            echo "<br>";
            echo "Ou você é do sexo masculino.";
        } else {
            echo "Nada será exibido !!!!";
        }
    }
    ?>

    <br><br>

    <h2>SWITCH e CASE (SEM BREAK)</h2>
    <?php
    $nome = "Thais";
    switch ($nome) {
        case "Norma";
            echo "<br>";
            echo "O nome é Norma";
        case "Thais";
            echo "<br>";
            echo "O nome é Thais";
        case "Sandra";
            echo "<br>";
            echo "O nome é Sandra";
    }
    ?>

    <br><br>

    <h2>SWITCH e CASE (COM BREAK)</h2>
    <?php
    $nome = "Sandra";
    switch ($nome) {
        case "Maria";
            echo "<br>";
            echo "O nome é Maria";
            break;
        case "Thais";
            echo "<br>";
            echo "O nome é Thais";
            break;
        case "Sandra";
            echo "<br>";
            echo "O nome é Sandra";
            break;
    }

    echo "<br>";
    echo "Fim do Switch";
    ?>

    <br><br>

    <h2>Uso do FOR</h2>
    <?php
    for ($index = 0; $index <= 20; $index += 2) {
        echo "Número: $index";
        echo "<br>";
    }
    ?>

    <br><br>

    <h2>Uso do WHILE</h2>
    <?php
    $index = 0;
    while ($index <= 10) {
        if ($index > 5) {
            echo "O Número $index é maior que 5!";
            echo "<br>";
        }
        $index++;
    }
    echo "<br>";
    echo "Fim do While";
    ?>

    <br><br>

    <h2>Usos de ARRAY (1)</h2>
    <?php
    $estado = array("SP", "RJ", "MG", "ES");
    $tot_elementos = count($estado); //tot_elementos terá o valor igual a 4
    
    for ($index = 0; $index < $tot_elementos; $index++) {
        echo "Estado: $estado[$index]";
        echo "<br>";
    }
    ?>

    <br><br>

    <h2>Usos de ARRAY (2)</h2>
    <?php
    $estado = array("SP", "RJ", "MG", "ES");
    foreach ($estado as $key => $value) {

        if ($value == "RJ" or $value == "SP") {
            echo "$value removido da região sudeste!";
            unset($estado[$key]); // removerá o elemento RJ  
            echo "<br>";
        }
    }

    // Reindexar o array
    $estado = array_values($estado);

    // Concatenar os valores "MG" e "ES" no array
    $novo_valor = "MG e ES agora é MG, e tem praia UwU";
    $estado = array($novo_valor);

    echo "<br>";

    foreach ($estado as $key => $value) {
        echo "Estado: $value";
        echo "<br>";
    }

    echo "<br>";
    ?>

    <br><br>

    <h2>Funções (1)</h2>
    <?php
    function imprimeMaiores()
    {
        echo " É maior que cinco";
    }

    for ($index = 0; $index <= 10; $index++) {
        echo "$index";
        if ($index > 5) {
            imprimeMaiores();
        }
        echo "<br>";
    }

    ?>

    <br><br>

    <h2>Funções (2)</h2>
    <?php
    function imprimeMaiores2($numero)
    {
        if($numero > 5){
            echo " É maior que cinco";
        }
    }

    for ($index = 0; $index <= 10; $index++) {
        echo "$index";
        imprimeMaiores2($index);
        echo "<br>";
    }
    ?>

    <br><br>

    <h2>Funções (3)</h2>
    <?php
    function soma($num1, $num2)
    {
        return $num1 + $num2;
    }

    $media = soma(10, 20) / 2;

    echo "Média: $media";
    ?>

    <br><br>

    <!-- Exemplo -->
    <?php
    ?>
</body>

</html>