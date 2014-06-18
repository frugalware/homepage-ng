<?php include("lib/footer.inc.php"); ?>

        </div>
    <!-- main content end -->
    </div>

    <!-- footer start -->
<?php
print "\n
    <footer>\n
        &copy;" . $copydate . " " . $title . " - 
        <a href=\"mailto:frugalware-devel@frugalware.org\">" . gettext("Contact Developer Team") . "</a> 
        - <a id=\"top\" href=\"javascript: toTop();\">" . gettext("Back to top") . "</a>\n
    </footer>\n";
?>
    <!-- footer end -->

    </body>
</html>
