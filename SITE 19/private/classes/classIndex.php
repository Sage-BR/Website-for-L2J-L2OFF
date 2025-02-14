<?php

class Index {
    /**
     * Retorna as notícias em ordem decrescente de data de postagem.
     *
     * @param int $pgBeg Início da paginação.
     * @param int $pgMax Número máximo de resultados.
     * @return mixed Lista de notícias ou false em caso de erro.
     */
    public static function News(int $pgBeg = 0, int $pgMax = 3): mixed {
        $sql = DB::Executa(
            "SELECT * FROM site_news WHERE vis = '1' ORDER BY post_date DESC, nid DESC LIMIT ?, ?",
            [$pgBeg, $pgMax]
        );
        return $sql;
    }

    /**
     * Conta o número total de notícias visíveis.
     *
     * @return mixed Quantidade total de notícias ou false em caso de erro.
     */
    public static function CountNews(): mixed {
        $sql = DB::Executa(
            "SELECT COUNT(*) AS quant FROM site_news WHERE vis = '1'"
        );
        return $sql[0]['quant'] ?? false;
    }

    /**
     * Retorna as notícias, exceto a especificada pelo ID.
     *
     * @param int $newID ID da notícia a ser excluída.
     * @param int $limit Número máximo de resultados.
     * @return mixed Lista de notícias ou false em caso de erro.
     */
    public static function NewsExcept(int $newID, int $limit = 3): mixed {
        $sql = DB::Executa(
            "SELECT * FROM site_news WHERE vis = '1' AND nid <> ? ORDER BY post_date DESC LIMIT ?",
            [$newID, $limit]
        );
        return $sql;
    }

    /**
     * Retorna os detalhes de uma única notícia.
     *
     * @param int $newID ID da notícia.
     * @return mixed Detalhes da notícia ou false em caso de erro.
     */
    public static function ViewNew(int $newID): mixed {
        $sql = DB::Executa(
            "SELECT * FROM site_news WHERE vis = '1' AND nid = ? LIMIT 1",
            [$newID]
        );
        return $sql[0] ?? false;
    }

    /**
     * Retorna a lista de banners visíveis.
     *
     * @return mixed Lista de banners ou false em caso de erro.
     */
    public static function Banners(): mixed {
        $sql = DB::Executa(
            "SELECT * FROM site_banners WHERE vis = '1' ORDER BY pos ASC"
        );
        return $sql;
    }
}
