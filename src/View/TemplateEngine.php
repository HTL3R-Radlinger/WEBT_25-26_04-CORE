<?php

namespace Radlinger\Mealplan\View;

class TemplateEngine
{
    public static function render(string $templatePath, array $data): string
    {
        $output = file_get_contents($templatePath);

        // MAIN LOOPS
        if (preg_match_all('/\{% for (\w+) in (\w+) %}(.*?)\{% endfor %}/s', $output, $matches, PREG_SET_ORDER)) {

            foreach ($matches as $match) {

                [$fullMatch, $itemVar, $arrayVar, $loopContent] = $match;

                $replacement = '';

                // ARRAY MUSS IM DATENWURZEL-BEREICH LIEGEN
                if (isset($data[$arrayVar]) && is_array($data[$arrayVar])) {

                    foreach ($data[$arrayVar] as $item) {

                        $renderedItemBlock = $loopContent;

                        // Hauptloop Variablen
                        $vars = is_object($item) ? get_object_vars($item) : (array)$item;

                        foreach ($vars as $key => $value) {
                            if (!is_array($value) && !is_object($value)) {
                                $renderedItemBlock =
                                    str_replace('{{' . $key . '}}', $value, $renderedItemBlock);
                            }
                        }

                        // ------------------------------------------
                        // SUBLOOPS DIREKT HIER VERARBEITEN
                        // ------------------------------------------
                        if (preg_match_all(
                            '/\{% subFor (\w+) in (\w+) %}(.*?)\{% endSubFor %}/s',
                            $renderedItemBlock,
                            $subMatches,
                            PREG_SET_ORDER
                        )) {

                            foreach ($subMatches as $subMatch) {

                                [$fullSub, $subItemVar, $subArrayVar, $subBlock] = $subMatch;

                                $subReplacement = '';

                                // WICHTIG: subLoops greifen NICHT auf $data zu,
                                //         sondern auf die VARS des aktuellen Plans!!!
                                if (isset($vars[$subArrayVar]) && is_array($vars[$subArrayVar])) {

                                    foreach ($vars[$subArrayVar] as $subItem) {

                                        $subBlockRendered = $subBlock;

                                        $subVars = is_object($subItem)
                                            ? get_object_vars($subItem)
                                            : (array)$subItem;
                                        foreach ($subVars as $sk => $sv) {
                                            if (!is_array($sv) && !is_object($sv)) {
                                                $subBlockRendered =
                                                    str_replace('{{' . $sk . '}}', $sv, $subBlockRendered);
                                            }
                                        }

                                        $subReplacement .= $subBlockRendered;
                                    }
                                }

                                // Ganzes Subloop-Element ersetzen
                                $renderedItemBlock =
                                    str_replace($fullSub, $subReplacement, $renderedItemBlock);
                            }
                        }

                        $replacement .= $renderedItemBlock;
                    }
                }

                $output = str_replace($fullMatch, $replacement, $output);
            }
        }

        // SIMPLE VARS (root-level)
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $output = str_replace('{{' . $key . '}}', $value, $output);
            }
        }

        return $output;
    }
}
