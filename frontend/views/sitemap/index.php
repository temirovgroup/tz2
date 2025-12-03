<?php

/**
 * Created by PhpStorm.
 */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $category \app\modules\admin\models\Category[]|array|\yii\db\ActiveRecord[] */
/* @var $product \app\modules\admin\models\Product[]|array|\yii\db\ActiveRecord[] */
/* @var $post \app\modules\admin\models\Post[]|array|\yii\db\ActiveRecord[] */
/* @var $linkInternet array */
/* @var $linkZvonki array */
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php $randZone = random_int(2000000, 2500000) ?>
    <url>
        <loc><?= Url::base(true) ?></loc>
        <lastmod><?= date('Y-m-d\TH:11:i', time() - $randZone) ?>+01:00</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= Url::to(['page/about'], true) ?></loc>
        <lastmod><?= date('Y-m-d\TH:11:i', time() - $randZone) ?>+01:00</lastmod>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= Url::to(['page/contact'], true) ?></loc>
        <lastmod><?= date('Y-m-d\TH:11:i', time() - $randZone) ?>+01:00</lastmod>
        <priority>1.0</priority>
    </url>
	<?php $randZone = random_int(2000000, 2500000) ?>
	<?php foreach ($product as $data) : ?>
		<url>
			<loc><?= Url::to(['site/product', 'url' => $data->url], true) ?></loc>
			<lastmod><?= date('Y-m-d\TH:11:i', time() - $randZone) ?>+01:00</lastmod>
			<priority>0.8</priority>
		</url>
	<?php endforeach; ?>
</urlset>
