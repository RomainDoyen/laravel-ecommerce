<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Produit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProduitSeeder extends Seeder
{
    /**
     * Image JPEG locale (~800×800) : dégradé discret selon la graine (aucun appel réseau).
     */
    private function imagePathForSlug(string $slug, int $seed): string
    {
        $relative = 'products/seed/'.$slug.'.jpg';

        if (Storage::disk('public')->exists($relative)) {
            return $relative;
        }

        if (! function_exists('imagecreatetruecolor')) {
            return 'assets/images/truck.svg';
        }

        $w = $h = 800;
        $im = imagecreatetruecolor($w, $h);
        $r1 = ($seed * 47 + 40) % 120 + 60;
        $g1 = ($seed * 91 + 20) % 120 + 60;
        $b1 = ($seed * 13 + 80) % 120 + 60;
        $r2 = min(255, $r1 + 85);
        $g2 = min(255, $g1 + 85);
        $b2 = min(255, $b1 + 85);

        for ($y = 0; $y < $h; $y++) {
            $t = $y / ($h - 1);
            $r = (int) round($r1 + ($r2 - $r1) * $t);
            $g = (int) round($g1 + ($g2 - $g1) * $t);
            $b = (int) round($b1 + ($b2 - $b1) * $t);
            $line = imagecolorallocate($im, $r, $g, $b);
            imageline($im, 0, $y, $w, $y, $line);
        }

        ob_start();
        imagejpeg($im, null, 90);
        $binary = ob_get_clean();
        imagedestroy($im);

        Storage::disk('public')->put($relative, $binary);

        return $relative;
    }

    private function categoryId(string $name): ?int
    {
        return Category::query()->where('name', $name)->value('id');
    }

    public function run(): void
    {
        /* `picsum_id` : graine pour la couleur du JPEG généré localement (sans téléchargement). */
        $items = [
            [
                'titre' => 'Casque sans fil à réduction de bruit',
                'description' => 'Casque circum-aural Bluetooth 5.2, autonomie jusqu’à 30 h, son Hi-Res et confort prolongé pour le télétravail et les voyages.',
                'prix' => 349.99,
                'prix_promotionnel' => 299.99,
                'promotion' => true,
                'quantity' => 24,
                'category' => 'Électronique',
                'picsum_id' => 131,
            ],
            [
                'titre' => 'Clavier mécanique sans fil',
                'description' => 'Switches tactiles silencieux, rétroéclairage blanc réglable, compatible Windows et macOS, autonomie longue durée.',
                'prix' => 129.90,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 40,
                'category' => 'Informatique',
                'picsum_id' => 180,
            ],
            [
                'titre' => 'Souris ergonomique verticale',
                'description' => 'Réduit la tension au poignet, capteur précis 2400 DPI, 6 boutons programmables, connexion USB ou sans fil.',
                'prix' => 49.99,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 55,
                'category' => 'Informatique',
                'picsum_id' => 119,
            ],
            [
                'titre' => 'Écran PC 27" QHD IPS',
                'description' => 'Résolution 2560×1440, 100 Hz, faible lumière bleue, pied réglable en hauteur, idéal bureautique et création.',
                'prix' => 289.00,
                'prix_promotionnel' => 259.00,
                'promotion' => true,
                'quantity' => 12,
                'category' => 'Informatique',
                'picsum_id' => 225,
            ],
            [
                'titre' => 'T-shirt coton bio col rond',
                'description' => '100 % coton biologique certifié, coupe droite, lavable à 30 °C, disponible en plusieurs coloris classiques.',
                'prix' => 24.90,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 120,
                'category' => 'Vêtements',
                'picsum_id' => 338,
            ],
            [
                'titre' => 'Jean slim stretch',
                'description' => 'Denim stretch confortable, cinq poches, braguette boutons, tissu résistant au frottement du quotidien.',
                'prix' => 79.99,
                'prix_promotionnel' => 69.99,
                'promotion' => true,
                'quantity' => 65,
                'category' => 'Vêtements',
                'picsum_id' => 325,
            ],
            [
                'titre' => 'Lampe de bureau LED dimmable',
                'description' => 'Lumière chaude/froide réglable, bras articulé, port USB de charge, consommation faible et design épuré.',
                'prix' => 45.00,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 38,
                'category' => 'Maison',
                'picsum_id' => 367,
            ],
            [
                'titre' => 'Cafetière à piston 1 L',
                'description' => 'Verre borosilicate, filtre inox, prépare environ 4 grandes tasses, entretien simple au lave-vaisselle (sans piston).',
                'prix' => 32.50,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 70,
                'category' => 'Cuisine',
                'picsum_id' => 292,
            ],
            [
                'titre' => 'Enceinte Bluetooth portable',
                'description' => 'Son stéréo 20 W, étanchéité IPX7 pour la douche ou l’extérieur, autonomie 12 h, kit mains-libres intégré.',
                'prix' => 119.00,
                'prix_promotionnel' => 99.00,
                'promotion' => true,
                'quantity' => 33,
                'category' => 'Électronique',
                'picsum_id' => 201,
            ],
            [
                'titre' => 'Montre connectée sport',
                'description' => 'GPS intégré, suivi cardio et sommeil, notifications smartphone, batterie multi-jours, bracelet silicone inclus.',
                'prix' => 199.00,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 28,
                'category' => 'Électronique',
                'picsum_id' => 99,
            ],
            [
                'titre' => 'Sac à dos ordinateur 15,6"',
                'description' => 'Compartiment matelassé laptop, poche RFID, dos aéré, volume 22 L, idéal trajets quotidiens.',
                'prix' => 59.90,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 45,
                'category' => 'Informatique',
                'picsum_id' => 429,
            ],
            [
                'titre' => 'Roman « La part du feu » (poche)',
                'description' => 'Prix littéraire, récit historique captivant — édition de poche, 480 pages.',
                'prix' => 9.50,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 200,
                'category' => 'Livres',
                'picsum_id' => 24,
            ],
            [
                'titre' => 'Guide de randonnée — Alpes du Nord',
                'description' => 'Topo détaillé, cartes IGN, difficultés et refuges, nouvelle édition mise à jour des sentiers.',
                'prix' => 22.90,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 85,
                'category' => 'Livres',
                'picsum_id' => 29,
            ],
            [
                'titre' => 'Jeu vidéo d’aventure (Switch)',
                'description' => 'Aventure monde ouvert, durée de jeu 40+ h, textes en français, boîte neuve scellée.',
                'prix' => 59.99,
                'prix_promotionnel' => 49.99,
                'promotion' => true,
                'quantity' => 60,
                'category' => 'Jeux vidéo',
                'picsum_id' => 445,
            ],
            [
                'titre' => 'Manette sans fil pour console',
                'description' => 'Batterie rechargeable, gyroscope, vibrations HD, compatible console courante — coloris noir mat.',
                'prix' => 64.90,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 90,
                'category' => 'Jeux vidéo',
                'picsum_id' => 452,
            ],
            [
                'titre' => 'Jeu de société stratégie (français)',
                'description' => '2 à 4 joueurs, 12 ans et +, parties 60–90 min, règles illustrées, pièces en bois.',
                'prix' => 44.90,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 42,
                'category' => 'Jouets',
                'picsum_id' => 193,
            ],
            [
                'titre' => 'Ballon de football taille 5',
                'description' => 'Cuir synthétique haute résistance, coutures renforcées, homologué matchs loisirs et entraînement.',
                'prix' => 29.00,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 100,
                'category' => 'Sports',
                'picsum_id' => 73,
            ],
            [
                'titre' => 'Bouteille isotherme 750 ml',
                'description' => 'Inox 18/10, garde 24 h froid / 12 h chaud, goulot large, sans BPA, finition mate.',
                'prix' => 27.90,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 150,
                'category' => 'Sports',
                'picsum_id' => 425,
            ],
            [
                'titre' => 'Tapis de yoga antidérapant',
                'description' => 'Épaisseur 6 mm, matériau TPE recyclable, lignes d’alignement, sac de transport inclus.',
                'prix' => 34.50,
                'prix_promotionnel' => 29.90,
                'promotion' => true,
                'quantity' => 75,
                'category' => 'Sports',
                'picsum_id' => 107,
            ],
            [
                'titre' => 'Crème hydratante visage 50 ml',
                'description' => 'Peaux normales à mixtes, acide hyaluronique, texture légère non grasse, testé dermatologiquement.',
                'prix' => 18.50,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 110,
                'category' => 'Beauté',
                'picsum_id' => 102,
            ],
            [
                'titre' => 'Huile démaquillante douce 150 ml',
                'description' => 'Dissout le maquillage waterproof, parfum léger, flacon pompe, convient aux peaux sensibles.',
                'prix' => 21.00,
                'prix_promotionnel' => null,
                'promotion' => false,
                'quantity' => 88,
                'category' => 'Beauté',
                'picsum_id' => 258,
            ],
            [
                'titre' => 'Chaise de bureau ergonomique',
                'description' => 'Lombaires réglables, accoudoirs 3D, hauteur et inclinaison du dossier, roulettes sols durs.',
                'prix' => 249.00,
                'prix_promotionnel' => 219.00,
                'promotion' => true,
                'quantity' => 15,
                'category' => 'Maison',
                'picsum_id' => 376,
            ],
        ];

        foreach ($items as $row) {
            $slug = Str::slug($row['titre']);
            $colorSeed = $row['picsum_id'];
            unset($row['picsum_id']);

            $categoryName = $row['category'];
            unset($row['category']);

            $row['category_id'] = $this->categoryId($categoryName);
            $row['image'] = $this->imagePathForSlug($slug, $colorSeed);

            Produit::updateOrCreate(
                ['titre' => $row['titre']],
                $row
            );
        }
    }
}
