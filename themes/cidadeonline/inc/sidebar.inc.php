<?php
$View = (!empty($View) ? $View : $View = new View());
$post_id = (!empty($post_id) ? $post_id : null);
$side = new Controle;
$tpl_p = $View->Load('article_p');
?>
<aside class="main-sidebar">
    <article class="ads">
        <header>
            <h1>Anúncio Patrocinado:</h1>
            <a href="http://www.upinside.com.br/campus" title="Campus UpInside - Treinamentos em TI 100% em Vídeo aulas">
                <img src="<?= INCLUDE_PATH; ?>/_tmp/banner_large.png" alt="UPINSIDE TEINAMENTOS" title="UPINSIDE TEINAMENTOS" />
            </a>
        </header>
    </article>

    <section class="widget art-list last-publish">
        <h2 class="line_title"><span class="oliva">Últimas Atualizações:</span></h2>
        <?php
        $side->setTable('ws_posts');
        $side->Query("post_status = 1 AND post_id != :side ORDER BY post_date DESC LIMIT 3", "side={$post_id}");
        if ($side->getResult()):
            foreach ($side->getResult() as $last):
                $last->datetime = date('Y-m-d', strtotime($last->post_date));
                $last->pubdate = date('d/m/Y H:i', strtotime($last->post_date));
                $View->Show((array) $last, $tpl_p);
            endforeach;
        endif;
        ?>
    </section>

    <section class="widget art-list most-view">
        <h2 class="line_title"><span class="vermelho">Destaques:</span></h2>
        <?php
        $side->setTable('ws_posts');
        $side->Query("post_status = 1 AND post_id != :side ORDER BY post_views DESC LIMIT 3", "side={$post_id}");
        if ($side->getResult()):
            foreach ($side->getResult() as $most):
                $most->datetime = date('Y-m-d', strtotime($most->post_date));
                $most->pubdate = date('d/m/Y H:i', strtotime($most->post_date));
                $View->Show((array) $most, $tpl_p);
            endforeach;
        endif;
        ?>
    </section>
</aside>