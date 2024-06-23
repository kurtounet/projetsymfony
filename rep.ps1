# Fonction pour afficher l'arborescence d'un dossier
function Show-Tree {
    param (
        [string]$Path = ".",
        [int]$Level = 0
    )

    # Obtenir les éléments du dossier
    $items = Get-ChildItem -Path $Path

    # Afficher chaque élément
    foreach ($item in $items) {
        # Préfixe avec des espaces pour l'indentation
        $prefix = " " * ($Level * 4)
        Write-Output "$prefix$item"

        # Si l'élément est un dossier, appeler récursivement la fonction
        if ($item.PSIsContainer) {
            Show-Tree -Path $item.FullName -Level ($Level + 1)
        }
    }
}

# Appeler la fonction avec le chemin du dossier souhaité
Show-Tree -Path "G:\.Labo\Symfony\projetsymfony\src"
Show-Tree -Path "G:\.Labo\Symfony\projetsymfony\templates"
