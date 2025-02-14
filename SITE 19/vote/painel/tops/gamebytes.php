<?php
//=======================================================================\\
//  ## ####### #######                                                   \\
//  ## ##      ##   ##                                                   \\
//  ## ##      ## ####  |\  | |¯¯¯ ¯¯|¯¯ \      / |¯¯¯| |¯¯¯| | / |¯¯¯|  \\
//  ## ##      ##       | \ | |--    |    \    /  | | | | |_| |<   ¯\_   \\
//  ## ####### ##       |  \| |___   |     \/\/   |___| | |\  | \ |___|  \\
// --------------------------------------------------------------------- \\
//       Brazillian Developer / WebSite: http://www.icpfree.com.br       \\
//=======================================================================\\

// Faz a requisição para a API.
$url = "https://www.gamebytes.net/api.php?ip=".get_client_ip()."&username=".$row->top_id;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$pagina = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Inicializa variáveis padrão.
$data_modificada = '0000-00-00 00:00:00';

// Verifica resposta da API.
if ($http_code === 200) {
    $voted = filter_var($pagina, FILTER_VALIDATE_BOOLEAN); // TRUE (já votou) ou FALSE (não votou).

    if ($voted && !isset($_COOKIE["gamebytes"])) {
        // Define cookie e tempo de próxima votação.
        ?>
        <script language="javascript">
            SetCookie('gamebytes');
        </script>
        <?php
    }

    // Atualiza a data modificada do cookie.
    if (isset($_COOKIE["gamebytes"])) {
        $data_modificada = pega_cookie($_COOKIE["gamebytes"]);
    }
}

// Lógica para verificar se pode votar.
if (strtotime($data_modificada) >= strtotime(date('Y-m-d H:i:s'))) {
    // Exibe contador se ainda não pode votar.
    $data_voto = explode("-", substr(str_replace(" ", "", $data_modificada), 0, 10));
    $hora_voto = explode(":", substr(str_replace(" ", "", $data_modificada), 10, 19));
    ?>
    <script language="javascript">
        atualizaContador(
            <?= htmlspecialchars($row->id); ?>,
            <?= htmlspecialchars($data_voto[0]); ?>,
            <?= htmlspecialchars($data_voto[1]); ?>,
            <?= htmlspecialchars($data_voto[2]); ?>,
            <?= htmlspecialchars($hora_voto[0]); ?>,
            <?= htmlspecialchars($hora_voto[1]); ?>,
            <?= htmlspecialchars($hora_voto[2]); ?>
        );
    </script>
    <div style="background:url(images/buttons/<?php echo $row->top_img; ?>); background-repeat: no-repeat; background-size: 87px 47px; width:87px; height:47px; border:1px solid #999; margin-top:5px; margin-left:5px; float:left;">
        <div style="width:87px; height:47px; font-size:10px; font-family:Arial; background: rgba(0, 0, 0, 0.8); text-shadow:1px 1px #000; font-weight:bold; color: #fff; text-align: center;">
            <?= $language_05; ?><br>
            <font size="3"><span id="contador<?= htmlspecialchars($row->id); ?>"></span></font><br>
            <?= $language_06; ?>
        </div>
    </div>
    <?php
} else {
    // Exibe botão de votação se o tempo já expirou ou ainda não votou.
    ?>
    <div style="width:87px; height:47px; border:1px solid #999; margin-top:5px; margin-left:5px; float:left;">
        <a href="https://www.gamebytes.net/index.php?a=in&u=<?= htmlspecialchars($row->top_id); ?>" target="_blank">
            <img src="images/buttons/<?= htmlspecialchars($row->top_img); ?>" 
                 title="GameBytes - Best Lineage 2 Toplist" 
                 border="0" width="87" height="47" 
                 onclick="document.cookie = 'gamebytes=' + new Date().toISOString();">
        </a>
    </div>
    <?php
}
?>
