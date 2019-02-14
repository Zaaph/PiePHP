<?php

    namespace Core;

    class TemplateEngine
    {
        public static function parser($view) {
            $patterns = array("/{{([^}]+)}}/", "/@(if *\(.+\))/",
                "/@(elseif *\(.+\))/", "/@(else)/", "/@(endif)/",
                "/@(foreach *\(.+\))/", "/@(endforeach)/",
                "/@(isset *\(.+\))/", "/@endisset/", "/@(empty *\(.+\))/",
                "/@endempty/");
            $replacements = array("<?php echo htmlentities($1) ?>",
                "<?php $1: ?>", "<?php $1: ?>", "<?php $1: ?>",
                "<?php $1; ?>", "<?php $1: ?>", "<?php $1; ?>",
                "<?php if ($1): ?>", "<?php endif; ?>", "<?php if($1): ?>",
                "<?php endif; ?>");
            $ret = preg_replace($patterns, $replacements, $view);
            return $ret;
        }
    }

?>