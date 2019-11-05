
<?foreach ($vars['type'] as $value):?>
<div>
    <h3><?=$value['name']?></h3>
    <form>
        <input type="hidden" value="<?=$value['id']?>" name = 'type'>
        <input type="hidden" value="add" name = 'mode'>
        <input type="text"  name = 'proxi'>
        <input type="submit" value="Спарсить">
    </form>
    <form>
        <input type="hidden" value="<?=$value['id']?>" name = 'type'>
        <input type="hidden" value="addResult" name = 'mode'>
        <input type="text"  name = 'proxi'>
        <input type="submit" value="Проверить">
    </form>
</div>
<? endforeach;?>
