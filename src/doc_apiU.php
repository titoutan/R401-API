<?php
/**
 * @api {get} /usagers Recuperer tout les usagers
 * @apiName GetUsagers
 * @apiGroup Usager
 * 
 * @apiSuccess {int} id L'identifiant de l'usager.
 * @apiSuccess {String} nom  le nom de l'usager.
 * @apiSuccess {String} prenom  le prenom de l'usager.
 * @apiSuccess {String} date_nais  la date de naissance de l'usager.
 * @apiSuccess {String} lieu_nais  le lieu de naissance de l'usager.
 * @apiSuccess {String} civilite  la civilité de l'usager.
 * @apiSuccess {char} sexe  le sexe de l'usager.
 * @apiSuccess {String} adresse  l'adresse de l'usager.
 * @apiSuccess {String} ville  la ville de l'usager.
 * @apiSuccess {String} code_postal  le code postal de l'usager.
 * @apiSuccess {String} num_secu  le numéro de sécurité sociale de l'usager.
 * 
 * @apiSuccessExample Success-Response:
 * {
 * status_code: 200,
 * status_message: "[R401 Rest API] Liste des usagers",
 * data:[{
 *     "id": 1,
 *     "nom": "Doe",
 *     "prenom": "John",
 *     "date_nais": "1990-01-01",
 *     "lieu_nais": "Paris",
 *     "civilite": "M",
 *     "sexe": "M",
 *     "adresse": "1 rue de Paris",
 *     "ville": "Paris",
 *     "code_postal": "75000",
 *     "num_secu": "123456789012345"
 * },{
 *    "id": 2,
 *    "nom": "Doe",
 *    "prenom": "Jane",
 *    "date_nais": "1990-01-01",
 *    "lieu_nais": "Paris",
 *    "civilite": "Mme",
 *    "sexe": "F",
 *    "adresse": "1 rue de Paris",
 *    "ville": "Paris",
 *    "code_postal": "75000",
 *    "num_secu": "123456789012345",
 *    "id_medecin": 1
 * }...]
 * }
 * 
 */
/**
 * @api {get} /usagers/:id Recuperer un usager spécifique
 * @apiName GetUsager
 * @apiGroup Usager
 * 
 * @apiParam {Number} id unique ID d'un usager.
 * 
 * @apiSuccess {int} status_code le code de statut de la requete.
 * @apiSuccess {int} status_message le message de statut de la requete.
 * 
 * @apiSuccess {int} id L'identifiant de l'usager.
 * @apiSuccess {String} nom  le nom de l'usager.
 * @apiSuccess {String} prenom  le prenom de l'usager.  
 * @apiSuccess {String} date_nais  la date de naissance de l'usager.    
 * @apiSuccess {String} lieu_nais  le lieu de naissance de l'usager.
 * @apiSuccess {String} civilite  la civilité de l'usager.
 * @apiSuccess {char} sexe  le sexe de l'usager.
 * @apiSuccess {String} adresse  l'adresse de l'usager.
 * @apiSuccess {String} ville  la ville de l'usager.
 * @apiSuccess {String} code_postal  le code postal de l'usager.
 * @apiSuccess {String} num_secu  le numéro de sécurité sociale de l'usager.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *      status_code: 200,
 *      status_message: "[R401 Rest API] Usager trouvé",
 *      data:{
 *         "id": 1,
 *         "nom": "Doe",
 *         "prenom": "John",
 *         "date_nais": "1990-01-01",
 *         "lieu_nais": "Paris",
 *         "civilite": "M",
 *         "sexe": "M",
 *         "adresse": "1 rue de Paris",
 *         "ville": "Paris",
 *         "code_postal": "75000",
 *         "num_secu": "123456789012345"
 *      }
 * }
 * 
 * @apiError NotFound Usager non trouvé.
 * @apiErrorExample Error-Response:
 * {
 *      status_code: 404
 *      status_message: "[R401 Rest API] Usager introuvable"
 * }
 * 
 */
/**
 * @api {post} /usagers Ajouter un usager
 * @apiName AddUsager
 * @apiGroup Usager
 * 
 * @apiQuery {String} nom  le nom de l'usager.
 * @apiQuery {String} prenom  le prenom de l'usager.
 * @apiQuery {String} date_nais  la date de naissance de l'usager.
 * @apiQuery {String} lieu_nais  le lieu de naissance de l'usager.
 * @apiQuery {String} civilite  la civilité de l'usager.
 * @apiQuery {char} sexe  le sexe de l'usager.  
 * @apiQuery {String} adresse  l'adresse de l'usager.
 * @apiQuery {String} ville  la ville de l'usager.
 * @apiQuery {String{5}} code_postal  le code postal de l'usager.
 * @apiQuery {String{13}} num_secu  le numéro de sécurité sociale de l'usager.
 * @apiQuery {int} id_medecin  [OPTIONNEL] l'id du médecin référent
 * 
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {int} status_message le message de statut de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *      status_code: 201
 *      status_message: "[R401 Rest API] Usager ajouté"
 * }
 * 
 * @apiError date Mauvais format de date
 * @apiError civilite Mauvaise civilité
 * @apiError sexe Mauvais sexe
 * @apiError code_postal Code postal invalide
 * @apiError num_secu Numéro de sécurité invalide (mauvais format ou duplication)
 * @apiError id_medecin Medecin introuvable
 * 
 * @apiErrorExample Date-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] format date invalide"
 * }
 * @apiErrorExample Civilite-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Civilité invalide"
 * }
 * @apiErrorExample Civilite-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Civilité invalide"
 * }
 * @apiErrorExample Sexe-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Sexe invalide"
 * }
 * @apiErrorExample Code-Postal-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Code postal invalide"
 * }
 * @apiErrorExample Numero-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Numéro de sécurité sociale invalide"
 * }
 * @apiErrorExample Numero-Duplique:
 * {
 *      status_code: 409
 *      status_message: "[R401 Rest API] Numéro de sécurité sociale déjà attribué"
 * }
 * @apiErrorExample Medecin-Invalide:
 * {
 *      status_code: 404
 *      status_message: "[R401 Rest API] Médecin introuvable"
 * }
 * 
 */
/**
 * @api {patch} /usagers/:id Modifier un usager 
 * @apiName UpdateUsager
 * @apiGroup Usager
 * 
 * @apiParam {Number} id unique ID d'un usager.
 * 
 * @apiQuery {String} nom  le nom de l'usager.
 * @apiQuery {String} prenom  le prenom de l'usager.
 * @apiQuery {String} date_nais  la date de naissance de l'usager.
 * @apiQuery {String} lieu_nais  le lieu de naissance de l'usager.
 * @apiQuery {String} civilite  la civilité de l'usager.
 * @apiQuery {char} sexe  le sexe de l'usager.
 * @apiQuery {String} adresse  l'adresse de l'usager.
 * @apiQuery {String} ville  la ville de l'usager.
 * @apiQuery {String} code_postal  le code postal de l'usager.
 * @apiQuery {String} num_secu  le numéro de sécurité sociale de l'usager.
 * 
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {int} status_message le message de statut de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *      status_code: 200
 *      status_message: "[R401 Rest API] Usager modifié"
 * }
 * 
 * @apiError NotFound Usager non trouvé.
 * @apiErrorExample Not Found:
 * {
 *      status_code: 404
 *      status_message:"[R401 Rest API] Usager introuvable",
 * }
 * 
 * 
 * @apiError date Mauvais format de date
 * @apiError civilite Mauvaise civilité
 * @apiError sexe Mauvais sexe
 * @apiError code_postal Code postal invalide
 * @apiError num_secu Numéro de sécurité invalide (mauvais format ou duplication)
 * @apiError id_medecin Medecin introuvable
 * 
 * @apiErrorExample Date-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] format date invalide"
 * }
 * @apiErrorExample Civilite-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Civilité invalide"
 * }
 * @apiErrorExample Civilite-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Civilité invalide"
 * }
 * @apiErrorExample Sexe-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Sexe invalide"
 * }
 * @apiErrorExample Code-Postal-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Code postal invalide"
 * }
 * @apiErrorExample Numero-Invalide:
 * {
 *      status_code: 400
 *      status_message: "[R401 Rest API] Numéro de sécurité sociale invalide"
 * }
 * @apiErrorExample Numero-Duplique:
 * {
 *      status_code: 409
 *      status_message: "[R401 Rest API] Numéro de sécurité sociale déjà attribué"
 * }
 * @apiErrorExample Medecin-Invalide:
 * {
 *      status_code: 404
 *      status_message: "[R401 Rest API] Médecin introuvable"
 * }
 */
/**
 * @api {delete} /usagers/:id Supprimer un usager
 * @apiName DeleteUsager
 * @apiGroup Usager
 * 
 * @apiParam {Number} id unique ID d'un usager.
 * 
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {int} status_message le code de statut de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *      status_code: 200
 *      status_message: "[R401 Rest API] Usager supprimé"
 * }
 * @apiError NotFound Usager non trouvé.
 * @apiErrorExample Not Found:
 * {
 *      status_code: 404
 *      status_message:"[R401 Rest API] Usager introuvable",
 * }
 */
