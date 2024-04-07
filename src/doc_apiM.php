<?php
/**
 * @api {get} /medecins Recuperer tout les medecins
 * @apiName GetMedecins
 * @apiGroup Medecin
 * 
 * @apiSuccess {int} id L'identifiant du medecin.
 * @apiSuccess {String} nom  le nom du medecin.
 * @apiSuccess {String} prenom  le prenom du medecin.
 * @apiSuccess {String} civilite  la civilité du medecin.
 * 
 * @apiSuccessExample Success-Response:
 * {
 * "status_code": 200,
 * "status_message": "[R401 Rest API] Liste des médecins",
 * "data": [
 *     {
 *         "id_medecin": 1,
 *         "civilite": "M.",
 *         "nom": "Martin",
 *         "prenom": "Gérard"
 *     },
 *     {
 *         "id_medecin": 2,
 *         "civilite": "M.",
 *         "nom": "Dupond",
 *         "prenom": "Gérard"
 *     } ... ]
 * }
 * 
  * 
 */
/**
 * @api {get} /medecins/:id Recuperer un medecin spécifique
 * @apiName GetMedecin
 * @apiGroup Medecin
 *
 * @apiParam {Number} id unique ID d'un medecin.
 *
 * @apiSuccess {int} id L'identifiant du medecin.
 * @apiSuccess {String} nom  le nom du medecin.
 * @apiSuccess {String} prenom  le prenom du medecin.
 * @apiSuccess {String} civilite  la civilité du medecin.
 *
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 200,
 *     "status_message": "[R401 Rest API] Medecin trouvé",
 *     "data": {
 *         "id_medecin": 1,
 *         "civilite": "M.",
 *         "nom": "Martin",
 *         "prenom": "Gérard"
 *     }
 * }
 *
 * @apiError Erreur Medecin non trouvé.
 *
 * @apiErrorExample Error-Response:
 * {
 *     "status_code": 404,
 *     "status_message": "[R401 Rest API] Medecin introuvable"
 * }
 */
/**
 * @api {post} /medecins Ajouter un medecin
 * @apiName AddMedecin
 * @apiGroup Medecin
 * 
 * @apiQuery {String} nom  le nom du medecin.
 * @apiQuery {String} prenom  le prenom du medecin.
 * @apiQuery {String} civilite  la civilité du medecin.
 * 
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {String} status_message  le message de status de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 201,
 *     "status_message": "[R401 Rest API] Medecin ajouté",
 *     "data": {
 *         "id_medecin": 3,
 *         "civilite": "M.",
 *         "nom": "Dupond",
 *         "prenom": "Gérard"
 *     }
 * }
 * @apiError Erreur Paramètres manquants
 * @apiErrorExample Erreur: 
 * {
 *     "status_code": 400,
 *     "status_message": "[R401 Rest API] Paramètre(s) manquant(s) pour créer un medecin"
 * }
 */
/**
 * @api {patch} /medecins/:id Modifier un medecin
 * @apiName UpdateMedecin
 * @apiGroup Medecin
 * 
 * @apiParam {Number} id unique ID d'un medecin.
 * @apiQuery {String} nom  le nom du medecin.
 * @apiQuery {String} prenom  le prenom du medecin.
 * @apiQuery {String} civilite  la civilité du medecin.
 * 
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {String} status_message  le message de status de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 200,
 *     "status_message": "[R401 Rest API] Medecin modifié",
 *     "data": {
 *         "id_medecin": 1,
 *         "civilite": "M.",
 *         "nom": "Martin",
 *         "prenom": "Gérard"
 *     }
 * }
 * 
 * @apiError NotFound medecin non trouvé
 * 
 * @apiErrorExample NotFound:
 * {
 *     "status_code": 404,
 *     "status_message": "[R401 Rest API] Medecin introuvable"
 * }
 */
  /**
 * @api {delete} /medecins/:id Supprimer un medecin
 * @apiName DeleteMedecin
 * @apiGroup Medecin
 * 
 * @apiParam {Number} id unique ID d'un medecin.
 * 
 * @apiSuccess {String} status  le status de la requete.
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {String} status_message  le message de status de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 200,
 *     "status_message": "[R401 Rest API] Medecin supprimé",
 *     "data": "3"
 * }
 * 
 * @apiError Erreur lors de la suppression du medecin.
 * 
 * @apiErrorExample Error-Response:
 *  {
 *      "status_code": 404,
 *      "status_message": "[R401 Rest API] Medecin introuvable"
 *  }
 */