<?php
class ResultProvider {

    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function getNumRsults($term) {
        $sql = "SELECT COUNT(*) as total
                FROM sites WHERE
                title LIKE :term
                OR url LIKE :term
                OR keywords Like :term";
        $query = $this->con->prepare($sql);
        $searchResult = "%".$term."%";
        $query->bindParam(":term", $searchResult);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row["total"];
    }

    public function getResultsHtml($page, $pageSize, $term)
    {

        $fromLimit = ($page - 1) * $pageSize;
        // page 1: (1-1) * 20 = 0
        // page 2: (2-1) * 20 = 20
        // page 3: (3-1) * 20 = 40
        $sql = "SELECT *
                FROM sites WHERE
                title LIKE :term
                OR url LIKE :term
                OR keywords Like :term
                ORDER BY clicks DESC LIMIT :fromLimit, :pageSize";
        $query = $this->con->prepare($sql);
        $searchResult = "%".$term."%";
        $query->bindParam(":term", $searchResult);
        $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
        $query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
        $query->execute();

        $resultsHtml = "<div class ='siteResults'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $title = $row["title"];
            $url = $row["url"];
            $description = $row["description"];
            $title = $this->trimField($title, 55);
            $description = $this->trimField($description, 200);
            $resultsHtml .= "<div class='resultContainer'>
                                <h3 class='title'>
                                    <a class='result' href='$url' data-linkId='$id' >
                                        $title
                                    </a>
                                </h3>
                                <span class='url'>$url</span>
                                <span class='description'>$description</span>
                            </div>";
        }
        $resultsHtml .= "</div>";

        return $resultsHtml;
    }

    private function trimField($str, $chrLimit) {

            $dots = strlen($str) > $chrLimit ? "..." : "";
            return substr($str, 0, $chrLimit) . $dots;
    }


}
?>
