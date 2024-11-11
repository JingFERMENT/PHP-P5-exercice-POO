<?php

function echoHelp(): string {
    return "Commandes disponibles :
            list                                    : liste les contacts
            detail [id]                             : afficher le détail d’un contact
            create [name], [email], [phone number]  : créer un contact
            modify [id]                             : modifier un contact
            delete [id]                             : supprimer un contact
            help                                    : afficher cette aide
            quit                                    : quitter le programme\n";
}
