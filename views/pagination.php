<?php defined('KING_PATH') or die('访问被拒绝.');
      /**
       * 前端分页模板
       *
       * @preview  « 上一页  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  下一页 »
       */
?>



<div class="hx_page2 cf">

    <span class="pageup">
        <?php if ($previousPage): ?>
        <a class="" href="<?php echo str_replace('{page}', $previousPage, $urls) ?>">上一页</a>
        <?php else: ?>
        <a class="one" href="javascript:">上一页</a>
        <?php endif ?>
    </span>
    <span class="page_mun cf">
        <?php if ($totalPages < 8): /* « 上一页  1 2 3 4 5 6 7 8  下一页 » */ ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $currentPage): ?>
        <a class="on" href="javascript:"><?php echo $i ?></a>
        <?php else: ?>
        <a href="<?php echo str_replace('{page}', $i, $urls) ?>"><?php echo $i ?></a>
        <?php endif ?>
        <?php endfor ?>
        <?php elseif ($currentPage < 5): /* « 上一页  1 2 3 4 5 6 … 25 26  下一页 » */ ?>
        <?php for ($i = 1; $i <= 5; $i++): ?>
        <?php if ($i == $currentPage): ?>
        <a class="on" href="javascript:"><?php echo $i ?></a>
        <?php else: ?>
        <a href="<?php echo str_replace('{page}', $i, $urls) ?>"><?php echo $i ?></a>
        <?php endif ?>
        <?php endfor ?>

        <span>&nbsp;&hellip;</span>
		<a href="<?php echo str_replace('{page}', $totalPages - 1, $urls) ?>"><?php echo $totalPages - 1 ?></a>
        <a href="<?php echo str_replace('{page}', $totalPages, $urls) ?>"><?php echo $totalPages ?></a>

        <?php elseif ($currentPage > $totalPages - 4): /* « 上一页  1 2 … 21 22 23 24 25 26  下一页 » */ ?>

        <a href="<?php echo str_replace('{page}', 1, $urls) ?>">1</a>
        <a href="<?php echo str_replace('{page}', 2, $urls) ?>">2</a>        
        <span>&nbsp;&hellip;</span>

        <?php for ($i = $totalPages - 4; $i <= $totalPages; $i++): ?>
        <?php if ($i == $currentPage): ?>
        <a class="on" href="javascript:"><?php echo $i ?></a>
        <?php else: ?>
        <a href="<?php echo str_replace('{page}', $i, $urls) ?>"><?php echo $i ?></a>
        <?php endif ?>
        <?php endfor ?>

        <?php else: /* « 上一页  1 2 … 4 5 6 7 8 … 25 26  下一页 » */ ?>

        <a href="<?php echo str_replace('{page}', 1, $urls) ?>">1</a>
        <a href="<?php echo str_replace('{page}', 2, $urls) ?>">2</a>
        <span>&nbsp;&hellip;</span>

        <?php for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++): ?>
        <?php if ($i == $currentPage): ?>
        <a class="on" href="javascript:"><?php echo $i ?></a>
        <?php else: ?>
        <a href="<?php echo str_replace('{page}', $i, $urls) ?>"><?php echo $i ?></a>
        <?php endif ?>
        <?php endfor ?>

        <span>&nbsp;&hellip;</span>
		<a href="<?php echo str_replace('{page}', $totalPages - 1, $urls) ?>"><?php echo $totalPages - 1 ?></a>
        <a href="<?php echo str_replace('{page}', $totalPages, $urls) ?>"><?php echo $totalPages ?></a>

        <?php endif ?>
    </span>
    <span class="pagenext">
        <?php if ($nextPage): ?>
        <a href="<?php echo str_replace('{page}', $nextPage, $urls) ?>">下一页</a>
        <?php else: ?>
        <a class="one" href="javascript:">下一页</a>
        <?php endif ?>
    </span>
    <span class="page_text">共<?php echo $totalPages; ?>页</span>
    <span class="page_input">到<input name="jumPage" id="jumPage" type="text" />页</span>
    <span class="page_btn"><a href="javascript:" onclick="pageLocation();">确定</a></span>

</div>

<script>

    function pageLocation(){
        var totalPage = <?php echo $totalPages; ?>;
        var page = document.getElementById('jumPage').value;
        var re = /^[1-9]+[0-9]*]*$/;
        if (!re.test(page)){
            alert("请输入正确的页码");
            return false;
        }
        if(page > totalPage){
            alert('没有那么多页');
            return false;
        }
        var url = '<?php echo $urls ?>';
        var junmUrl = url.replace('{page}',page);
        window.location.href = junmUrl;
    }

</script>
