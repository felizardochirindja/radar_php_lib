<?php

namespace Radar\Core;

/**
 * Define os tipos de filtros suportados
 */
enum DataFilter: int
{
    /** 
     * @var int Filtro para validação de e-mail 
     * O valor numérico associado refere-se à constante FILTER_VALIDATE_EMAIL nativa PHP.
     */
    case Email = 274;

    /** 
     * @var int Filtro para validação de URL 
     * O valor numérico associado refere-se à constante FILTER_VALIDATE_URL nativa PHP.
     */
    case Url = 273;

    public function getFilter(): int
    {
        return match ($this) {
            self::Email => FILTER_VALIDATE_EMAIL,
            self::Url => FILTER_VALIDATE_URL,
        };
    }
}
