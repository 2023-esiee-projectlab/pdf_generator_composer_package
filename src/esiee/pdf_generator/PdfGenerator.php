<?php
    /**
     * Espace de travail : src\esiee\pdf_generator
     */
    namespace pdf_generator;

    /**
     * Importations des classes nécessaires.
     */
    //use CleanString;
    //use CustomTCPDF;
    include('CleanString.php');
    include('CustomTCPDF.php');

    /**
     * Classe : PdfGenerator.php
     * <br/>Cette classe permet de générer un fichier PDF.
     */
    class PdfGenerator
    {
        private $pdf = null;
        private $pdf_createur = null;
        private $pdf_auteur = null;
        private $pdf_titre = null;
        private $pdf_sujet = null;
        //-
        private $pdf_config_saut_de_ligne = 0;
        private $pdf_config_saut_des_interlignes = 0;
        //-
        private $pdf_config_tcpdf_orientation = null;
        private $pdf_config_tcpdf_unit = null;
        private $pdf_config_tcpdf_format = null;
        private $pdf_config_tcpdf_encoding = null;
        //-
        private $pdf_config_tcpdf_border = null;
        private $pdf_config_tcpdf_images = null;
        //-
        private $pdf_config_tcpdf_diskcache = null;
        private $pdf_config_tcpdf_pdfa = null;
        private $pdf_config_tcpdf_pdfaauto = null;
        //-
        private $pdf_parametres_contenu_forme_police = null;
        private $pdf_parametres_contenu_forme_marges = null;
        //-
        private $pdf_parametres_contenu_fond_header = null;
        private $pdf_parametres_contenu_fond_bottom = null;
        //-
        private $pdf_informations_ready = false;
        private $pdf_config_ready = false;
        private $pdf_config_tcpdf_ready = false;
        private $pdf_config_tcpdf_border_and_images_ready = false;
        private $pdf_config_tcpdf_more_ready = false;
        private $pdf_parametres_contenu_forme_ready = false;
        private $pdf_parametres_contenu_fond_ready = false;
        //-
        private $pdf_pages_de_garde = null;
        private $pdf_pages_de_separation = null;
        private $pdf_pages_de_couverture = null;
        private $pdf_pages_de_fin = null;
        private $pdf_pages_contenu = null;

        /**
         * PdfGenerator constructor.
         */
        public function __construct(){}

        /**
         * Cette méthode permet de définir les informations du PDF.
         * @param $pdf_createur
         * @param $pdf_auteur
         * @param $pdf_titre
         * @param $pdf_sujet
         * @return void
         */
        public function setPdfInformations($pdf_createur, $pdf_auteur, $pdf_titre, $pdf_sujet){
            $this->pdf_createur = $pdf_createur;
            $this->pdf_auteur = $pdf_auteur;
            $this->pdf_titre = $pdf_titre;
            $this->pdf_sujet = $pdf_sujet;
            $this->pdf_informations_ready = true;
        }

        /**
         * Cette méthode permet de définir les configurations du PDF.
         * @param $pdf_config_saut_de_ligne
         * @param $pdf_config_saut_des_interlignes
         * @return void
         */
        public function setPdfConfig($pdf_config_saut_de_ligne, $pdf_config_saut_des_interlignes){
            $this->pdf_config_saut_de_ligne = $pdf_config_saut_de_ligne;
            $this->pdf_config_saut_des_interlignes = $pdf_config_saut_des_interlignes;
            $this->pdf_config_ready = true;
        }

        /**
         * Cette méthode permet de définir les configurations du PDF avec TCPDF.
         * @param $pdf_config_tcpdf_orientation
         * @param $pdf_config_tcpdf_format
         * @param $pdf_config_tcpdf_encoding
         * @return void
         */
        public function setPdfConfigTcpdf($pdf_config_tcpdf_orientation, $pdf_config_tcpdf_unit, $pdf_config_tcpdf_format, $pdf_config_tcpdf_encoding){
            $this->pdf_config_tcpdf_orientation = $pdf_config_tcpdf_orientation;
            $this->pdf_config_tcpdf_unit = $pdf_config_tcpdf_unit;
            $this->pdf_config_tcpdf_format = $pdf_config_tcpdf_format;
            $this->pdf_config_tcpdf_encoding = $pdf_config_tcpdf_encoding;
            $this->pdf_config_tcpdf_ready = true;
        }

        /**
         * Cette méthode permet d'activer les bordures (Header & Footer) et les images du PDF.
         * @param $pdf_config_tcpdf_border
         * @param $pdf_config_tcpdf_images
         * @return void
         */
        public function setPdfConfigTcpdfBorderAndImages($pdf_config_tcpdf_border, $pdf_config_tcpdf_images){
            $this->pdf_config_tcpdf_border = $pdf_config_tcpdf_border;
            $this->pdf_config_tcpdf_images = $pdf_config_tcpdf_images;
            $this->pdf_config_tcpdf_border_and_images_ready = true;
        }

        /**
         * Cette méthode permet de définir les configurations supplémentaires du PDF.
         * @param $diskcache
         * @param $pdfa
         * @param $pdfauto
         * @return void
         */
        public function setPdfConfigTcpdfMore($diskcache, $pdfa, $pdfaauto){
            $this->pdf_config_tcpdf_diskcache = $diskcache;
            $this->pdf_config_tcpdf_pdfa = $pdfa;
            $this->pdf_config_tcpdf_pdfaauto = $pdfaauto;
            $this->pdf_config_tcpdf_more_ready = true;
        }

        /**
         * Cette méthode permet de définir les paramètres de forme du contenu du PDF.
         * @param $pdf_parametres_contenu_forme_police
         * @param $pdf_parametres_contenu_forme_marges
         * @return void
         */
        public function setPdfParametresContenuForme($pdf_parametres_contenu_forme_police, $pdf_parametres_contenu_forme_marges){
            $this->pdf_parametres_contenu_forme_police = $pdf_parametres_contenu_forme_police;
            $this->pdf_parametres_contenu_forme_marges = $pdf_parametres_contenu_forme_marges;
            $this->pdf_parametres_contenu_forme_ready = true;
        }

        /**
         * Cette méthode permet de définir les paramètres de fond du contenu du PDF.
         * @param $pdf_parametres_contenu_fond_header
         * @param $pdf_parametres_contenu_fond_bottom
         * @return void
         */
        public function setPdfParametresContenuFond($pdf_parametres_contenu_fond_header, $pdf_parametres_contenu_fond_bottom){
            $this->pdf_parametres_contenu_fond_header = $pdf_parametres_contenu_fond_header;
            $this->pdf_parametres_contenu_fond_bottom = $pdf_parametres_contenu_fond_bottom;
            $this->pdf_parametres_contenu_fond_ready = true;
        }

        /**
         * Cette méthode permet de définir les pages de garde, de séparation, de couverture et de fin du PDF.
         * @param $pages_de_garde
         * @param $pages_de_separation
         * @param $pages_de_couverture
         * @param $pages_de_fin
         * @return void
         */
        public function setPagesCouvertures($pages_de_garde, $pages_de_separation, $pages_de_couverture, $pages_de_fin){
            $this->pdf_pages_de_garde = $pages_de_garde;
            $this->pdf_pages_de_separation = $pages_de_separation;
            $this->pdf_pages_de_couverture = $pages_de_couverture;
            $this->pdf_pages_de_fin = $pages_de_fin;
        }

        /**
         * Cette méthode permet de définir le contenu du PDF.
         * @param $pages
         * @return void
         */
        public function setContenu($pages){
            $this->pdf_pages_contenu = $pages;
        }

        /**
         * Cette méthode permet d'insérer le Header et le Footer du PDF.
         * @return void
         */
        public function insertHeaderAndFooter(){
            $this->pdf->setPdfParams(
                $this->pdf_config_saut_de_ligne, // Saut de ligne
                $this->pdf_config_saut_des_interlignes, // Interlignes
                $this->pdf_titre, // Titre
                $this->pdf_parametres_contenu_fond_header[0], // Image
                $this->pdf_parametres_contenu_fond_header[1], // Largeur de l'image
                'SVG', // Type de l'image
                $this->pdf_parametres_contenu_forme_police // Police
            );
            $this->pdf->Header();
            $this->pdf->Footer();
            $this->pdf->Ln($this->pdf_config_saut_des_interlignes); // Ajout de deux lignes vides
        }

        /**
         * Cette méthode permet de générer le PDF.
         * @return void
         */
        public function generatePDF(){
            // Initialisation du PDF avec TCPDF
            $this->pdf = new CustomTCPDF(
                $this->pdf_config_tcpdf_orientation, // Orientation
                $this->pdf_config_tcpdf_unit, // Unité de mesure
                $this->pdf_config_tcpdf_format, // Format
                ($this->pdf_parametres_contenu_fond_ready==true) ? true : false, // Permet de gérer les en-têtes et pieds de page
                $this->pdf_config_tcpdf_encoding, // Permet de gérer les accents
                ($this->pdf_config_tcpdf_border_and_images_ready==true) ? true : false // Permet de ne pas afficher les images
            );

            // ---[ Configuration des informations du PDF ]---
            $this->pdf->SetCreator($this->pdf_createur);
            $this->pdf->SetAuthor($this->pdf_auteur);
            $this->pdf->SetTitle($this->pdf_titre);
            $this->pdf->SetSubject($this->pdf_sujet);

            $this->pdf->setPrintHeader(false);
            $this->pdf->setPrintFooter(false);

            // ---[ Configuration des paramètres du PDF ]---
            /**
             * Configuration de la police
             * boolean $subsetting - Sous-ensemble
             */
            $this->pdf->setFontSubsetting(true);
            /**
             * Configuration de la police
             * string $family - Police
             * string $style - Style
             * string $size - Taille
             */
            $this->pdf->SetFont(
                $this->pdf_parametres_contenu_forme_police[0],
                $this->pdf_parametres_contenu_forme_police[1],
                $this->pdf_parametres_contenu_forme_police[2]
            );

            /**
             * Configuration des marges
             * int $left - Gauche
             * int $top - Haut
             * int $right - Droite
             * int $bottom - Bas
             * boolean $setAutoPageBreak
             */
            $this->pdf->SetMargins(
                $this->pdf_parametres_contenu_forme_marges[0],
                $this->pdf_parametres_contenu_forme_marges[1],
                $this->pdf_parametres_contenu_forme_marges[2],
                $this->pdf_parametres_contenu_forme_marges[3]
            );

            /**
             * Création des pages de garde
             */
            // Page de garde
            $this->pdf->AddPage();
            //-
            $this->insertHeaderAndFooter();
            //-
            $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Titre du PDF : '.$this->pdf_titre.'', 0, 1);
            $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Sujet du PDF : '.$this->pdf_sujet.'', 0, 1);
            $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Auteur du PDF : '.$this->pdf_auteur.'', 0, 1);
            $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Créateur du PDF : '.$this->pdf_createur.'', 0, 1);

            /**
             * Configuration des pages
             */
            foreach ($this->pdf_pages_contenu as $page){
                $this->pdf->AddPage();
                //-
                $this->insertHeaderAndFooter();
                //-
                if($page['title']=='Demo - Line to line'){
                    // Ajout d'un text de façcon classqiues : lignes par lignes
                    $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Titre : '.$page['title'].'', 0, 1);
                    $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Sous-titre : '.$page['sub_title'].'', 0, 1);
                    $text = explode("\n", $page['text']);
                    $x=0;
                    foreach ($text as $line){
                        $this->pdf->Cell(0,  $this->pdf_config_saut_de_ligne, 'Text : '.$page['text'].'', 0, $x);
                        //$this->pdf->Cell(0,  $this->pdf_config_saut_de_ligne, 'Text : '.$page['text'].'', 0, 'J', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
                        $x++;
                    }
                }
                else if($page['title']=='Demo - Multi line'){
                    // Ajout d'un text de façcon classqiues : lignes par lignes
                    $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Titre : '.$page['title'].'', 0, 1);
                    $this->pdf->Cell(0, $this->pdf_config_saut_de_ligne, 'Sous-titre : '.$page['sub_title'].'', 0, 1);
                    $this->pdf->MultiCell(0,  $this->pdf_config_saut_de_ligne, 'Text : '.$page['text'].'');
                    //$this->pdf->MultiCell(0,  $this->pdf_config_saut_de_ligne, 'Text : '.$page['text'].'', 0, 'J', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
                }
                else
                {
                    // Ajout d'un text de façcon HTML : traitement des balises HTML
                    $this->pdf->writeHTML($page['title']);
                    $this->pdf->writeHTML($page['sub_title']);
                    $this->pdf->writeHTML($page['text']);
                }
            }

            // ---[ Configuration du Haut et du Bas de page ]---
            /**
             * Configuration du Haut de page
             */
            $this->pdf->SetHeaderData(
                $this->pdf_parametres_contenu_fond_header[0], // Logo
                $this->pdf_parametres_contenu_fond_header[1], // Largeur du logo
                $this->pdf_parametres_contenu_fond_header[2], // Titre
                $this->pdf_parametres_contenu_fond_header[3] // Sous-titre
            );
            /**
             * Configuration du Bas de page
             */
            $this->pdf->setFooterData(
                $this->pdf_parametres_contenu_fond_bottom[0], // Logo
                $this->pdf_parametres_contenu_fond_bottom[1], // Largeur du logo
                $this->pdf_parametres_contenu_fond_bottom[2], // Titre
                $this->pdf_parametres_contenu_fond_bottom[3] // Sous-titre
            );

            // ---[ Préparation du titre du PDF ]---
            $cleanString = new CleanString();
            $titrePDF = $cleanString->CleaningStringForFileTitle($this->pdf_titre);

            // ---[ Génération du PDF ]---
            $this->pdf->Output($titrePDF.'.pdf', 'D');
        }

        /**
         * @return null
         */
        public function getPdfCreateur()
        {
            return $this->pdf_createur;
        }

        /**
         * @param null $pdf_createur
         */
        public function setPdfCreateur($pdf_createur)
        {
            $this->pdf_createur = $pdf_createur;
        }

        /**
         * @return null
         */
        public function getPdfAuteur()
        {
            return $this->pdf_auteur;
        }

        /**
         * @param null $pdf_auteur
         */
        public function setPdfAuteur($pdf_auteur)
        {
            $this->pdf_auteur = $pdf_auteur;
        }

        /**
         * @return null
         */
        public function getPdfTitre()
        {
            return $this->pdf_titre;
        }

        /**
         * @param null $pdf_titre
         */
        public function setPdfTitre($pdf_titre)
        {
            $this->pdf_titre = $pdf_titre;
        }

        /**
         * @return null
         */
        public function getPdfSujet()
        {
            return $this->pdf_sujet;
        }

        /**
         * @param null $pdf_sujet
         */
        public function setPdfSujet($pdf_sujet)
        {
            $this->pdf_sujet = $pdf_sujet;
        }

        /**
         * @return null
         */
        public function getPdfConfigTcpdfOrientation()
        {
            return $this->pdf_config_tcpdf_orientation;
        }

        /**
         * @param null $pdf_config_tcpdf_orientation
         */
        public function setPdfConfigTcpdfOrientation($pdf_config_tcpdf_orientation)
        {
            $this->pdf_config_tcpdf_orientation = $pdf_config_tcpdf_orientation;
        }

        /**
         * @return null
         */
        public function getPdfConfigTcpdfFormat()
        {
            return $this->pdf_config_tcpdf_format;
        }

        /**
         * @param null $pdf_config_tcpdf_format
         */
        public function setPdfConfigTcpdfFormat($pdf_config_tcpdf_format)
        {
            $this->pdf_config_tcpdf_format = $pdf_config_tcpdf_format;
        }

        /**
         * @return null
         */
        public function getPdfConfigTcpdfEncoding()
        {
            return $this->pdf_config_tcpdf_encoding;
        }

        /**
         * @param null $pdf_config_tcpdf_encoding
         */
        public function setPdfConfigTcpdfEncoding($pdf_config_tcpdf_encoding)
        {
            $this->pdf_config_tcpdf_encoding = $pdf_config_tcpdf_encoding;
        }

        /**
         * @return null
         */
        public function getPdfParametresContenuPolice()
        {
            return $this->pdf_parametres_contenu_police;
        }

        /**
         * @param null $pdf_parametres_contenu_police
         */
        public function setPdfParametresContenuPolice($pdf_parametres_contenu_police)
        {
            $this->pdf_parametres_contenu_police = $pdf_parametres_contenu_police;
        }

        /**
         * @return null
         */
        public function getPdfParametresContenuMarges()
        {
            return $this->pdf_parametres_contenu_marges;
        }

        /**
         * @param null $pdf_parametres_contenu_marges
         */
        public function setPdfParametresContenuMarges($pdf_parametres_contenu_marges)
        {
            $this->pdf_parametres_contenu_marges = $pdf_parametres_contenu_marges;
        }

        /**
         * @return null
         */
        public function getPdfParametresContenuHeader()
        {
            return $this->pdf_parametres_contenu_header;
        }

        /**
         * @param null $pdf_parametres_contenu_header
         */
        public function setPdfParametresContenuHeader($pdf_parametres_contenu_header)
        {
            $this->pdf_parametres_contenu_header = $pdf_parametres_contenu_header;
        }

        /**
         * @return null
         */
        public function getPdfParametresContenuBottom()
        {
            return $this->pdf_parametres_contenu_bottom;
        }

        /**
         * @param null $pdf_parametres_contenu_bottom
         */
        public function setPdfParametresContenuBottom($pdf_parametres_contenu_bottom)
        {
            $this->pdf_parametres_contenu_bottom = $pdf_parametres_contenu_bottom;
        }
    }