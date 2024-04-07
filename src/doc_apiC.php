<?php
/**
 * @api {get} /consultations Recuperer toutes les consultations.
 * @apiName GetConsultations
 * @apiGroup Consultation
 * 
 * @apiSuccess {int} id_consult L'identifiant de la consultation.
 * @apiSuccess {String} date_consult  la date de la consultation.
 * @apiSuccess {String} heure_consult  l'heure de la consultation.
 * @apiSuccess {int} duree_consult  l'heure de la consultation.
 * @apiSuccess {int} id_medecin  id du medecin.
 * @apiSuccess {int} id_usager  id de l'usager.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *      status:"OK",
 *      status_code: 200,
 *      data:[{
 *          "id_consult": 1,
 *          "date_consult": "2024-10-12",
 *          "heure_consult": "11:30:00",
 *          "duree_consult": 30,
 *          "id_medecin": 1,
 *          "id_usager": 2
 *      },
 *      {
 *          "id_consult": 4,
 *          "date_consult": "2024-10-12",
 *          "heure_consult": "10:00:00",
 *          "duree_consult": 30,
 *          "id_medecin": 2,
 *          "id_usager": 2
 *      }...]
 * }
 */
/**
 * @api {get} /consultations/:id Recuperer une consultation spécifique
 * @apiName GetConsultation
 * @apiGroup Consultation
 * 
 * @apiParam {int} id unique ID d'une consultation.
 * 
 * @apiSuccess {int} id_consult L'identifiant de la consultation.
 * @apiSuccess {String} date_consult  la date de la consultation.
 * @apiSuccess {String} heure_consult  l'heure de la consultation.
 * @apiSuccess {int} duree_consult  l'heure de la consultation.
 * @apiSuccess {int} id_medecin  id du medecin.
 * @apiSuccess {int} id_usager  id de l'usager.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 200,
 *     "status_message": "[R401 Rest API] Consultation trouvée",
 *     "data": {
 *         "id_consult": 4,
 *         "id_medecin": 2,
 *         "id_usager": 2,
 *         "heure_consult": "10:00",
 *         "date_consult": "12/10/2024",
 *         "duree_consult": 30
 *     }
 * }
 * 
 * @apiError NotFound Consultation non trouvée.
 * @apiErrorExample Error-Response:
 * {
 *     "status_code": 404,
 *     "status_message": "[R401 Rest API] Consultation introuvable"
 * }
 */
/**
 * @api {post} /consultations Ajouter une consultation
 * @apiName AddConsultation
 * @apiGroup Consultation
 * 
 * @apiQuery {String} date_consult  la date de la consultation.
 * @apiQuery {String} heure_consult  l'heure de la consultation.
 * @apiQuery {int} duree_consult  l'heure de la consultation.
 * @apiQuery {int} id_medecin  id du medecin.
 * @apiQuery {int} id_usager  id de l'usager.
 * 
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {int} status_message le message de statut de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 201,
 *     "status_message": "[R401 Rest API] Consultation ajoutée",
 *     "data": {
 *         "id_consult": 6,
 *         "id_medecin": 2,
 *         "id_usager": 2,
 *         "heure_consult": "10:00",
 *         "date_consult": "12/10/2024",
 *         "duree_consult": 30
 *     }
 * }
 * 
 * @apiError Date format de date invalide
 * @apiError Heure format de l'heure invalide
 * @apiError Durée durée de la consultation invalide
 * @apiErrorExample Date invalide:
 * {
 *     "status_code": 400,
 *     "status_message": "[R401 Rest API] Date de consultation invalide"
 * }
 * @apiErrorExample Heure invalide:
 * {
 *     "status_code": 400,
 *     "status_message": "[R401 Rest API] Heure de consultation invalide"
 * }
 * @apiErrorExample Durée invalide:
 * {
 *     "status_code": 400,
 *     "status_message": "[R401 Rest API] Duree de consultation invalide"
 * }
 */
/**
 * @api {patch} /consultations/:id Modifier une consultation
 * @apiName UpdateConsultation
 * @apiGroup Consultation
 * 
 * @apiParam {Number} id unique ID d'une consultation.
 * @apiQuery {String} date  la date de la consultation.
 * @apiQuery {String} heure  l'heure de la consultation.
 * @apiQuery {int} id_medecin  id du medecin.
 * @apiQuery {int} id_usager  id de l'usager.
 * 
 * @apiSuccess {int} status_code  le code de status de la requete.
 * @apiSuccess {int} status_message le message de statut de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 200,
 *     "status_message": "[R401 Rest API] Consultation modifiée",
 *     "data": {
 *         "id_consult": 6,
 *         "id_medecin": 2,
 *         "id_usager": 2,
 *         "heure_consult": "12:30",
 *         "date_consult": "10/10/2024",
 *         "duree_consult": 45
 *     }
 * }
 * 
 * @apiError NotFound Consultation non trouvée.
 * @apiError Date format de date invalide
 * @apiError Heure format de l'heure invalide
 * @apiError Durée durée de la consultation invalide
 * @apiErrorExample NotFound:
 * {
 *     "status_code": 404,
 *     "status_message": "[R401 Rest API] Consultation introuvable"
 * } 
 * @apiErrorExample Date invalide:
 * {
 *     "status_code": 400,
 *     "status_message": "[R401 Rest API] Date de consultation invalide"
 * }
 * @apiErrorExample Heure invalide:
 * {
 *     "status_code": 400,
 *     "status_message": "[R401 Rest API] Heure de consultation invalide"
 * }
 * @apiErrorExample Durée invalide:
 * {
 *     "status_code": 400,
 *     "status_message": "[R401 Rest API] Duree de consultation invalide"
 * }
 */
/**
 * @api {delete} /consultations/:id Supprimer une consultation
 * @apiName DeleteConsultation
 * @apiGroup Consultation
 * 
 * @apiParam {Number} id unique ID d'une consultation.
 * 
 * @apiSuccess {String} status  le status de la requete.
 * 
 * @apiSuccessExample Success-Response:
 * {
 *     "status_code": 200,
 *     "status_message": "[R401 Rest API] Consultation supprimée",
 *     "data": "6"
 * }
 * 
 * @apiError Consultation non trouvé
 * @apiErrorExample Error-Response:{
 *     "status_code": 404,
 *     "status_message": "[R401 Rest API] Consultation introuvable"
 * }
 * 
 */