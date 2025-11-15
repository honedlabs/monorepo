<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Illuminate\Support\Stringable;

trait Annotatable
{
    /**
     * The annotations to be added to the doc block.
     *
     * @var list<string>
     */
    protected $annotations = [];

    /**
     * Annotate the method with the given comment.
     *
     * @return $this
     */
    public function annotate(string $annotation = ''): static
    {
        $this->doc[] = $annotation;

        return $this;
    }

    /**
     * Annotate the return type of the method.
     *
     * @return $this
     */
    public function annotateReturn(string $return): static
    {
        return $this->annotate("@return  {$return}");
    }

    /**
     * Annotate a parameter with the given type and description.
     *
     * @return $this
     */
    public function annotateParam(string $param): static
    {
        return $this->annotate("@param  {$param}");
    }

    /**
     * Annotate a thrown exception with the given type and description.
     *
     * @return $this
     */
    public function annotateThrows(string $throws): static
    {
        return $this->annotate("@throws  {$throws}");
    }

    /**
     * Annotate the template of the method.
     *
     * @return $this
     */
    public function annotateTemplate(string $template): static
    {
        return $this->annotate("@template  {$template}");
    }

    /**
     * Get the annotations as a string.
     */
    public function annotations(int $indentations = 4): string
    {
        return \implode('', [
            $this->startAnnotation($indentations),
            $this->annotationBody($indentations),
            $this->endAnnotation($indentations),
        ]);
    }

    /**
     * Start the annotation block with the given indentation.
     */
    protected function startAnnotation(int $indentations = 4): string
    {
        return str_repeat(' ', $indentations).'/**'.PHP_EOL;
    }

    /**
     * Get the body of the annotation block with the given indentation.
     */
    protected function annotationBody(int $indentations = 4): string
    {
        return implode(PHP_EOL, array_map(
            fn ($annotation) => $this->formatAnnotation($annotation, $indentations),
            $this->annotations)
        );
    }

    /**
     * End the annotation block with the given indentation.
     */
    protected function endAnnotation(int $indentations = 4): string
    {
        return str_repeat(' ', $indentations).' */'.PHP_EOL;
    }

    /**
     * Format the annotation with the given indentation.
     */
    protected function formatAnnotation(string $annotation, int $indentations = 4): string
    {
        return (new Stringable($annotation))
            ->prepend(' * ', str_repeat(' ', $indentations))
            ->toString();
    }
}
