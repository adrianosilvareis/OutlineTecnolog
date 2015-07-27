<?php
$View = new View();
$tpl_g = $View->Load('article_g');
$tpl_m = $View->Load('article_m');
$tpl_p = $View->Load('article_p');
$tpl_empresa = $View->Load('empresa_p');
?>
<!--HOME SLIDER-->
<section class="main-slider">
    <h3>Últimas Atualizações:</h3>
    <div class="container">
        
        <div class="slidecount">
            <?php
            $cat = Check::CatByName('noticias');
            $post = new Controle;
            $post->setTable('ws_posts');
            $post->FullRead("SELECT * FROM ws_posts WHERE post_status = 1 AND (post_cat_parent = :cat OR post_category = :cat) ORDER BY post_date DESC LIMIT :limit OFFSET :offset", "cat={$cat}&limit=3&offset=0", true);
            
            if (!$post->getResult()):
                WSErro('Desculpe, ainda não existem notícias cadastradas. Favor volte mais tarde!', WS_INFOR);
            else:
                foreach ($post->getResult() as $slide):
                    $slide->post_title = Check::Words($slide->post_title, 12);
                    $slide->post_content = Check::Words($slide->post_content, 38);
                    $slide->datetime = date('Y-m-d', strtotime($slide->post_date));
                    $slide->pubdate = date('d/m/Y H:i', strtotime($slide->post_date));

                    $View->Show((array) $slide, $tpl_g);
                endforeach;
            endif;
            ?>                
        </div>

        <div class="slidenav"></div>   
    </div><!-- Container Slide -->

</section><!-- /slider -->


<!--HOME CONTENT-->
<div class="site-container">

    <section class="main-destaques">
        <h2>Destaques:</h2>

        <section class="main_lastnews">
            <h1 class="line_title"><span class="oliva">Últimas Notícias:</span></h1>

            <?php
            $post->Busca("cat={$cat}&limit=1&offset=3");
            if (!$post->getResult()):
                WSErro('Desculpe, não existe uma noticia destaque para ser exibida. Favor, volte depois', WS_INFOR);
            else:
                $new = $post->getResult()[0];
                $new->post_title = Check::Words($new->post_title, 12);
                $new->post_content = Check::Words($new->post_content, 38);
                $new->datetime = date('Y-m-d', strtotime($new->post_date));
                $new->pubdate = date('d/m/Y H:i', strtotime($new->post_date));
                $View->Show((array) $new, $tpl_m);
            endif;
            ?>

            <div class="last_news">
                <?php
                $post->Busca("cat={$cat}&limit=4&offset=4");
                if (!$post->getResult()):
                    WSErro("Desculpe, não temos mais noticias para serem exibidas aqui. Favor, volte depois!", WS_INFOR);
                else:
                    foreach ($post->getResult() as $news):
                        $news->post_title = Check::Words($news->post_title, 12);
                        $news->datetime = date('Y-m-d', strtotime($news->post_date));
                        $news->pubdate = date('d/m/Y H:i', strtotime($news->post_date));
                        $View->Show((array) $news, $tpl_p);
                    endforeach;
                endif;
                ?>
            </div>


            <nav class="guia_comercial">
                <h1>Guia de Empresas:</h1>
                <ul class="navitem">
                    <li id="comer" class="azul tabactive">Onde Comer</li>
                    <li id="ficar">Onde Ficar</li>
                    <li id="comprar" class="verde">Onde Comprar</li>
                    <li id="divertir" class="roxo">Onde se Divertir</li>
                </ul>
                
                <div class="tab comer">
                    <?php
                    $empcat = 'onde-comer';
                    $empresa = new Controle('app_empresas');
                    $empresa->Query("empresa_status = 1 AND #empresa_categoria# ORDER BY rand() LIMIT 4", "empresa_categoria={$empcat}");
                    
                    if (!$empresa->getResult()):
                        WSErro("Desculpe, não existem empresas cadastradas na categoria ONDE COMER. Favor, volte depois!", WS_INFOR);
                    else:
                        foreach ($empresa->getResult() as $emp):
                            $View->Show((array) $emp, $tpl_empresa);
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <div class="tab ficar none">
                    <?php
                    $empcat = 'onde-ficar';
                    $empresa->Busca("empresa_categoria={$empcat}");
                    
                    if (!$empresa->getResult()):
                        WSErro("Desculpe, não existem empresas cadastradas na categoria ONDE FICAR. Favor, volte depois!", WS_INFOR);
                    else:
                        foreach ($empresa->getResult() as $emp):
                            $View->Show((array) $emp, $tpl_empresa);
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <div class="tab comprar none">
                    <?php
                    $empcat = 'onde-comprar';
                    $empresa->Busca("empresa_categoria={$empcat}");
                    if (!$empresa->getResult()):
                        WSErro("Desculpe, não existem empresas cadastradas na categoria ONDE COMPRAR. Favor, volte depois!", WS_INFOR);
                    else:
                        foreach ($empresa->getResult() as $emp):
                            $View->Show((array) $emp, $tpl_empresa);
                        endforeach;
                    endif;
                    ?>
                </div>

                <div class="tab divertir none">
                    <?php
                    $empcat = 'onde-se-divertir';
                    $empresa->Busca("empresa_categoria={$empcat}");
                    if (!$empresa->getResult()):
                        WSErro("Desculpe, não existem empresas cadastradas na categoria ONDE SE DIVERTIR. Favor, volte depois!", WS_INFOR);
                    else:
                        foreach ($empresa->getResult() as $emp):
                            $View->Show((array) $emp, $tpl_empresa);
                        endforeach;
                    endif;
                    ?>
                </div>                        
            </nav>
        </section><!--  last news -->

        <aside>
            <div class="aside-banner">
                <!--300x250-->
                <a href="http://www.upinside.com.br/campus" title="Campus UpInside - Cursos Profissionais em TI">
                    <img src="<?= INCLUDE_PATH; ?>/_tmp/banner_large.png" title="Campus UpInside - Cursos Profissionais em TI" alt="Campus UpInside - Cursos Profissionais em TI" />
                </a>
            </div>

            <h1 class="line_title"><span class="vermelho">Destaques:</span></h1>

            <?php
            $post->Query("post_status = 1 ORDER BY post_views DESC, post_date DESC LIMIT 3");
            
            if (!$post->getResult()):
                WSErro("Desculpe, nenhuma noticia em destaque neste momento. Favor volte depois!", WS_INFOR);
            else:
                foreach ($post->getResult() as $aposts):
                    $aposts->post_title = Check::Words($aposts->post_title, 12);
                    $aposts->datetime = date('Y-m-d', strtotime($aposts->post_date));
                    $aposts->pubdate = date('d/m/Y H:i', strtotime($aposts->post_date));
                    $View->Show((array) $aposts, $tpl_p);
                endforeach;
            endif;
            ?>
        </aside>               

    </section><!-- destaques -->


    <section class="last_forcat">

        <h1>Por categoria!</h1>

        <section class="eventos">
            <h2 class="line_title"><span class="roxo">Eventos:</span></h2>

            <?php
            $cat = Check::CatByName('Eventos');
            if ($cat):
                $post->Query("post_status = 1 AND post_category = :cat ORDER BY post_views DESC, post_date DESC LIMIT :limit OFFSET :offset", "cat={$cat}&limit=3&offset=0", true);
                if (!$post->getResult()):
                    WSErro('Desculpe, não existe uma noticia destaque para ser exibida. Favor, volte depois', WS_INFOR);
                else:
                    $new = $post->getResult()[0];
                    $new->post_title = Check::Words($new->post_title, 9);
                    $new->post_content = Check::Words($new->post_content, 20);
                    $new->datetime = date('Y-m-d', strtotime($new->post_date));
                    $new->pubdate = date('d/m/Y H:i', strtotime($new->post_date));
                    $View->Show((array) $new, $tpl_m);
                endif;
            endif;
            ?>

            <div class="last_news">
                <?php
                if ($cat):
                    $post->Busca("cat={$cat}&limit=3&offset=1");
                    if (!$post->getResult()):
                        WSErro("Desculpe, não temos mais noticias para serem exibidas aqui. Favor, volte depois!", WS_INFOR);
                    else:
                        foreach ($post->getResult() as $news):
                            $news->post_title = Check::Words($news->post_title, 12);
                            $news->datetime = date('Y-m-d', strtotime($news->post_date));
                            $news->pubdate = date('d/m/Y H:i', strtotime($news->post_date));
                            $View->Show((array) $news, $tpl_p);
                        endforeach;
                    endif;
                endif;
                ?>
            </div>
        </section>


        <section class="esportes">
            <h2 class="line_title"><span class="verde">Esportes:</span></h2>

            <?php
            $cat = Check::CatByName('Esportes');
            if ($cat):
                $post->Busca("cat={$cat}&limit=1&offset=0");
                if (!$post->getResult()):
                    WSErro('Desculpe, não existe uma noticia destaque para ser exibida. Favor, volte depois', WS_INFOR);
                else:
                    $new = $post->getResult()[0];
                    $new->post_title = Check::Words($new->post_title, 9);
                    $new->post_content = Check::Words($new->post_content, 20);
                    $new->datetime = date('Y-m-d', strtotime($new->post_date));
                    $new->pubdate = date('d/m/Y H:i', strtotime($new->post_date));
                    $View->Show((array) $new, $tpl_m);
                endif;
            endif;
            ?>

            <div class="last_news">
                <?php
                if ($cat):
                    $post->Busca("cat={$cat}&limit=3&offset=1");
                    if (!$post->getResult()):
                        WSErro("Desculpe, não temos mais noticias para serem exibidas aqui. Favor, volte depois!", WS_INFOR);
                    else:
                        foreach ($post->getResult() as $news):
                            $news->post_title = Check::Words($news->post_title, 12);
                            $news->datetime = date('Y-m-d', strtotime($news->post_date));
                            $news->pubdate = date('d/m/Y H:i', strtotime($news->post_date));
                            $View->Show((array) $news, $tpl_p);
                        endforeach;
                    endif;
                endif;
                ?>
            </div>
        </section>


        <section class="baladas">
            <h2 class="line_title"><span class="azul">Baladas:</span></h2>

            <?php
            $cat = Check::CatByName('Baladas');
            if ($cat):
                $post->Busca("cat={$cat}&limit=1&offset=0");
                if (!$post->getResult()):
                    WSErro('Desculpe, não existe uma noticia destaque para ser exibida. Favor, volte depois', WS_INFOR);
                else:
                    $new = $post->getResult()[0];
                    $new->post_title = Check::Words($new->post_title, 9);
                    $new->post_content = Check::Words($new->post_content, 20);
                    $new->datetime = date('Y-m-d', strtotime($new->post_date));
                    $new->pubdate = date('d/m/Y H:i', strtotime($new->post_date));
                    $View->Show((array) $new, $tpl_m);
                endif;
            endif;
            ?>

            <div class="last_news">
                <?php
                if ($cat):
                    $post->Busca("cat={$cat}&limit=3&offset=1");
                    if (!$post->getResult()):
                        WSErro("Desculpe, não temos mais noticias para serem exibidas aqui. Favor, volte depois!", WS_INFOR);
                    else:
                        foreach ($post->getResult() as $news):
                            $news->post_title = Check::Words($news->post_title, 12);
                            $news->datetime = date('Y-m-d', strtotime($news->post_date));
                            $news->pubdate = date('d/m/Y H:i', strtotime($news->post_date));
                            $View->Show((array) $news, $tpl_p);
                        endforeach;
                    endif;
                endif;
                ?>
            </div>
        </section>

    </section><!-- categorias -->
    <div class="clear"></div>
</div><!--/ site container -->