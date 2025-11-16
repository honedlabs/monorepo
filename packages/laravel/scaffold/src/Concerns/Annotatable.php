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
     * Add an annotation.
     *
     * @return $this
     */
    public function annotate(string $annotation = ''): static
    {
        $this->annotations[] = $annotation;

        return $this;
    }

    /**
     * Annotate the return type.
     *
     * @return $this
     */
    public function annotateReturn(string $return): static
    {
        return $this->annotate("@return  {$return}");
    }

    /**
     * Annotate a parameter.
     *
     * @return $this
     */
    public function annotateParam(string $param): static
    {
        return $this->annotate("@param  {$param}");
    }

    /**
     * Annotate a thrown exception.
     *
     * @return $this
     */
    public function annotateThrows(string $throws): static
    {
        return $this->annotate("@throws  {$throws}");
    }

    /**
     * Annotate a template.
     *
     * @return $this
     */
    public function annotateTemplate(string $template): static
    {
        return $this->annotate("@template  {$template}");
    }

    /**
     * Annotate an implementation.
     *
     * @return $this
     */
    public function annotateImplements(string $implements): static
    {
        return $this->annotate("@implements  {$implements}");
    }

    /**
     * Annotate a uses clause.
     */
    public function annotateUses(string $uses): static
    {
        return $this->annotate("@uses  {$uses}");
    }

    /**
     * Get the annotations as a string.
     */
    public function annotations(int $indentations = 4): string
    {
        return \implode(PHP_EOL, [
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
        return str_repeat(' ', $indentations).'/**';
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
        return str_repeat(' ', $indentations).' */';
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
