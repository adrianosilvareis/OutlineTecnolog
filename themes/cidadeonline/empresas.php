<!--HOME CONTENT-->
<?php
$EmpLink = $Link->getData()['empresa_link'];
$Cat = $Link->getData()['empresa_cat'];
?>
<div class="site-container">

    <section class="page_empresas">
        <header class="emp_header">
            <h2><?= $Cat; ?></h2>
            <p class="tagline">Conheça as empresas cadastradas no seu guia online. Encontre aqui empresas <?= $Cat; ?></p>
        </header>

        <?php
        $getPage = (!empty($Link->getLocal()[2]) ? $Link->getLocal()[2] : 1);
        $Pager = new Pager(HOME . '/empresas/' . $EmpLink . '/');
        $Pager->ExePager($getPage, 5);

        $readEmp = new Controle();
        $readEmp->setTable('app_empresas');
        $readEmp->Query("empresa_status = 1 AND empresa_categoria = :cat ORDER BY empresa_date DESC LIMIT :limit OFFSET :offset", "cat={$EmpLink}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}", true);
        if (!$readEmp->getResult()):
            $Pager->ReturnPage();
            WSErro("Desculpe, ainda não existem empresas cadastradas {$Cat}, favor volte depois", WS_INFOR);
        else:
            $View = new View;
            $tpl = $View->Load('empresa_list');
            foreach ($readEmp->getResult() as $emp):
                //encontra cidade
                $readEmp->setTable('app_cidades');
                $readEmp->find("cidade_id={$emp->empresa_cidade}");
                $cidade = $readEmp->getResult()->cidade_nome;
                $emp->empresa_cidade = $cidade;

                //encontra estado
                $readEmp->setTable('app_estados');
                $readEmp->find("estado_id={$emp->empresa_uf}");
                $estado = $readEmp->getResult()->estado_uf;
                $emp->empresa_uf = $estado;

                $View->Show((array) $emp, $tpl);
            endforeach;
            
            //barra de navegação
            echo '<footer>';
            echo '<nav class="paginator">';
            echo '<h2>Mais resultados para NOME DA CATEGORIA</h2>';
            $Pager->ExePaginator("app_empresas", "empresa_status = 1 AND empresa_categoria = :cat", "cat={$EmpLink}");
            echo $Pager->getPaginator();
            echo '</nav>';
            echo '</footer>';
        endif;
        ?>

    </section>

    <!--SIDEBAR-->
    <?php require(REQUIRE_PATH . '/inc/sidebar.inc.php'); ?>

    <div class="clear"></div>
</div><!--/ site container -->