<table class="table">
    <tr>
        <td>العنوان</td>
        <td>النوع</td>
        <td>المؤلف</td>
        <td>الناشر</td>
    </tr>
    <?php foreach($books as $book){ ?>
       <tr>
            <td><?php echo $book->getTitle(); ?></td>
            <td><?php echo $book->getbibloType()["ar"]; ?></td>
            <td><?php echo $book->getAuthor()["author"]; ?></td>
            <td><?php echo $book->getPublisher()["publisher"]; ?></td>
        </tr>
    <?php } ?>
</table>