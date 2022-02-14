<?php
//パラメータがスラッグと一致しない場合に404エラーを発生させる
//single.phpのget_header()直前で呼び出し
//パラメータがスラッグと一致しない場合に404エラーを発生させる
function adjustParamater404() {
    $url =  get_pagenum_link(get_query_var('page')); //表示中のページ
    $cate = get_the_category();
    $tagName = $cate[0]->slug; //スラッグを取得

    //親カテゴリがある場合には親を参照する
    if ($cate[0]->category_parent) {
        $tagName = get_category($cate[0]->category_parent);
        $tagName = $tagName->slug;
    }

    $erased = substr($url, 0, strrpos($url, '/'));
    $para = substr($erased, strrpos($erased, '/') + 1, strlen($erased) - strrpos($erased, '/'));

    if ((int) $para) {
        $urlNeo = str_replace($para.'/', '', $url);
        $erased = substr($urlNeo, 0, strrpos($urlNeo, '/'));
        $para = substr($erased, strrpos($erased, '/') + 1, strlen($erased) - strrpos($erased, '/'));
        #echo 'このページのパラメータは'.$para.'です。<br>';
    }

    if ($para == $tagName) {
        #echo 'このページのパラメータは'.$para.'です。<br>';
        #echo 'このページのパラメータはスラッグである「'.$tagName.'」と一致しています。';
        return null;
    } else {
        #echo 'このページのパラメータは'.$para.'です。<br>';
        #echo 'このページのパラメータはスラッグである「'.$tagName.'」一致していません。';
        //wp_redirect(home_url().'/articles/'.$tagName.'/');
        header('HTTP/1.0 404 Not Found');
        wp_redirect('/404.php', 301);
        //include(TEMPLATEPATH.'/404.php');
        //exit;
        return null;
    }
    return null;
}
add_action('tes_tag', 'adjustParamater404');