Как удалить ссылку на авторе и дате комментария
 
link-kom Предлагаю элегантное и простое решение, которое позволит удалить ссылку на авторе комментария и дате публикации этого комментария на CMS WordPress.

Для WordPress 2.7 и выше. Все работает и после очередного обновления движка, т.е. не нужно каждый раз повторять действия.

Приступим. Открываем файл comments.php и ищем там подобное:

<?php wp_list_comments(); ?>
и заменяем на

<?php wp_list_comments('callback=mytheme_comment'); ?>
Теперь открываем файл функций functions.php и размещаем в нем сразу в начале файла с новой строки после <?php следующее:

// удаляем линк на автора комментария
function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
    <div class="comment-author vcard">
    <?php echo get_avatar($comment,$size='48',$default='http://mojwp.ru/wp-content/themes/mojwpthemes/images/gravatar-mojwp.gif' ); ?>
     <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author()) ?>
    </div>
    <?php if ($comment->comment_approved == '0') : ?>
    <em><?php _e('Your comment is awaiting moderation.') ?></em>
    <br />
    <?php endif; ?>
    <div class="autorurl"><? echo get_comment_author_url() ?></div>
    <div class="comment-meta commentmetadata"><?php printf(__('%1$s'), get_comment_date('d.m.Y')) ?></div>
    <?php comment_text() ?>
     <div class="reply">
    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    </div>
    <?php
    }
По итогу у вас получится нечто подобное (имя, снизу url не активный, еще ниже дата комментария):

Screenshot_10

В коде есть возможность поменять размер выводимого граватара, путь до картинки по-умолчанию (сейчас путь до моей). Также без проблем можно оформить стили блока и текста. Тут уже ваша фантазия должна проявить себя.

Если хотите чтобы вообще не показывало даже прописью URL сайта комментария, то нужно удалить из кода выше вот эту строку:

<div class="autorurl"><? echo get_comment_author_url() ?></div>
Также можно проставить активную ссылку на URL домена (по желанию закрываем в rel="nofollow"):

<div class="autorurl"><a href="<? comment_author_url() ?>"><? echo get_comment_author_url() ?></a></div>
Если не хотите выводить дату комментария, то удаляем эту строку:

<div class="comment-meta commentmetadata"><?php printf(__('%1$s'), get_comment_date('d.m.Y')) ?></div>
В этой же строке можем менять формат подачи даты d.m.Y - сейчас через точку день.месяц.год. Корректируйте как хотите очередность и знаки между ними.

Все. Вопросы задавайте в комментариях.

Дополнение
Приведу один случай, когда мой код можно не использовать.

Если в файле comments.php идет такой вызов списка комментариев:

<?php wp_list_comments('callback=custom_comments'); ?>
Здесь уже вызывается индивидуальный стиль для списка. Т.е. где-то у вас в шаблоне будет лежать файл wp_list_comments.php или подобное название, где вы сможете по моему коду выше подкорректировать get_comment_author() (имя комментатора без ссылки) и get_comment_author_url() (вызов непосредственно названия домена).

Здесь callback=custom_comments как раз и вызывает индивидуальный стиль, т.е. это для вас и будет ориентиром, что нужно поискать отдельный файл.