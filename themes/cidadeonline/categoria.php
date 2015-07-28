<?php
if ($Link->getData()):
    extract($Link->getData());
else:
    header('Location: ' . HOME . DIRECTORY_SEPARATOR . '404');
endif;
?>
<!--HOME CONTENT-->
<div class="site-container">

    <section class="page_categorias">
        <header class="cat_header">
            <h2><?= $category_title; ?></h2>
            <p class="tagline"><?= $category_content; ?></p>
        </header>

        <?php
        $getPage = (int)(!empty($Link->getLocal()[2]) ? $Link->getLocal()[2] : 1);
        $Pager = new Pager(HOME . '/categoria/' . $category_name . '/');
        $Pager->ExePager($getPage, 2);
        
        $readCat = new WsPosts();
        $readCat->Execute()->Query("post_status = 1 AND (post_category = :cat OR post_cat_parent = :cat) ORDER BY post_date DESC LIMIT :limit OFFSET :offset", "cat={$category_id}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}", true);
        if (!$readCat->Execute()->getResult()):
            $Pager->ReturnPage();
            WSErro("Desculpe, a categoria <b>{$category_title}</b> ainda não tem artigos publicados, favor volte mais tarde!", WS_INFOR);
        else:
            $cc = 0;
            foreach ($readCat->Execute()->getResult() as $cat):
                $cc++;
                $View = new View();
                $tpl_cat = $View->Load('article_m');
                $class = ($cc % 3 == 0 ? ' class="right"' : null);
                echo "<span{$class}>";
                $cat->post_title = Check::Words($cat->post_title, 8);
                $cat->post_content = Check::Words($cat->post_content, 20);
                $cat->datetime = date('Y-m-d', strtotime($cat->post_date));
                $cat->pubdate = date('d/m/Y H:i', strtotime($cat->post_date));
                $View->Show((array) $cat, $tpl_cat);
                echo "</span>";
            endforeach;
        endif;

        $Pager->ExePaginator("ws_posts", "post_status = 1 AND (post_category = :cat OR post_cat_parent = :cat)", "cat={$category_id}");

        echo '<nav class="paginator">';
        echo '<h2>Mais resultados para NOME DA CATEGORIA</h2>';
        echo $Pager->getPaginator();
        echo '</nav>';
        ?>

    </section>

    <div class="clear"></div>
</div><!--/ site container -->