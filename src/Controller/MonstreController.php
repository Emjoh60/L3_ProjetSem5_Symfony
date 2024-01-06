<?php
    namespace App\Controller;
    use App\Entity\Monstre;
    use App\Entity\Royaume;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\IntegerType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request; 
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class MonstreController extends AbstractController{
        public function accueil() {
            return $this->render('Monsterland/accueil.html.twig',array());
        }
        // ACTION 1 et 15
        public function afficherListeMonstre() {
            $repo = $this->getDoctrine()->getManager()->getRepository(Monstre::class);
            $monstre = $repo->findAll();
            dump($monstre);
            return $this->render('Monsterland/listeMonstre.html.twig',array("monstres"=>$monstre));
        }
        // ACTION 2
        public function ajouterMonstre(Request $request) {
            $monstre = new Monstre;
            $form = $this->createFormBuilder($monstre)
                ->add('nom', TextType::class)
                ->add('type', TextType::class)
                ->add('puissance', IntegerType::class)
                ->add('taille', IntegerType::class)
                ->add('envoyer', SubmitType::class)
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($monstre);
                $entityManager->flush();
                return $this->redirectToRoute('listeMonstre',array());
            }
            return $this->render('Monsterland/ajouterMonstre.html.twig',array('monFormulaire' => $form->createView()));
        }
        // ACTION 3
        public function modifierMonstre($id,Request $request) {
            $monstre = $this->getDoctrine()->getRepository(Monstre::class)->find($id);
            if(!$monstre){
                throw $this->createNotFoundException('Monstre[id='.$id.'] inexistant');
            }
            $form = $this->createFormBuilder($monstre)
                ->add('nom', TextType::class)
                ->add('type', TextType::class)
                ->add('puissance', IntegerType::class)
                ->add('taille', IntegerType::class)
                ->add('royaume', IntegerType::class) // ACTION 11
                ->add('modifier', SubmitType::class)
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($monstre);
                $entityManager->flush();
                return $this->redirectToRoute('listeMonstre',array('id'=>$id));
            }
            return $this->render('Monsterland/modifierMonstre.html.twig',array('monFormulaire' => $form->createView()));
        }
        // ACTION 4
        public function voirMonstre($id) {
            $monstre = $this->getDoctrine()->getRepository(Monstre::class)->find($id);
            if(!$monstre)
                throw $this->createNotFoundException('Monstre[id='.$id.'] inexistant');
            return $this->render('Monsterland/voirMonstre.html.twig',array('monstre' => $monstre));
        }
        // ACTION 5
        public function supprimerMonstre($id) {
            $em = $this->getDoctrine()->getManager();
            $monstre = $this->getDoctrine()->getRepository(Monstre::class)->find($id);
            $em->remove($monstre);
            $em->flush();
            return $this->redirectToRoute('listeMonstre',array('id'=>$id));
        }
        // ACTION 6
        public function afficherListeRoyaume() {
            $repo = $this->getDoctrine()->getManager()->getRepository(Royaume::class);
            $royaume = $repo->findAll();
            dump($royaume);
            return $this->render('Monsterland/listeRoyaume.html.twig',array("royaumes"=>$royaume));
        }
        // ACTION 7
        public function ajouterRoyaume(Request $request) {
            $royaume = new Royaume;
            $form = $this->createFormBuilder($royaume)
                ->add('nom', TextType::class)
                ->add('envoyer', SubmitType::class)
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($royaume);
                $entityManager->flush();
                return $this->redirectToRoute('listeRoyaume',array());
            }
            return $this->render('Monsterland/ajouterRoyaume.html.twig',array('monFormulaire' => $form->createView()));
        }
        // ACTION 8
        public function modifierRoyaume($id,Request $request) {
            $royaume = $this->getDoctrine()->getRepository(Royaume::class)->find($id);
            if(!$royaume){
                throw $this->createNotFoundException('Royaume[id='.$id.'] inexistant');
            }
            $form = $this->createFormBuilder($royaume)
                ->add('nom', TextType::class)
                ->add('modifier', SubmitType::class)
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($royaume);
                $entityManager->flush();
                return $this->redirectToRoute('listeRoyaume',array('id'=>$id));
            }
            return $this->render('Monsterland/modifierRoyaume.html.twig',array('monFormulaire' => $form->createView()));
        }
        // ACTION 9
        public function afficherListeMonstreRoyaume($id,Request $request) {
            $repo = $this->getDoctrine()->getManager()->getRepository(Monstre::class);
            $monstre = $repo->findBy(array('royaume'=>$id));
            $royaume = $this->getDoctrine()->getRepository(Royaume::class)->find($id);
            dump($monstre);
            return $this->render('Monsterland/afficherListeMonstreRoyaume.html.twig',array('monstres' => $monstre,'royaume' => $royaume));
        }
        // ACTION 10
        public function supprimerRoyaume($id) {
            $em = $this->getDoctrine()->getManager();
            $monstres = $this->getDoctrine()->getRepository(Monstre::class)->findByRoyaume($id);
            foreach($monstres as $monstre){
                $monstre->setRoyaume(null);
                $em->persist($monstre);
            }
            $em->flush();
            $royaume = $this->getDoctrine()->getRepository(Royaume::class)->find($id);
            $em->remove($royaume);
            $em->flush();
            return $this->redirectToRoute('listeRoyaume',array('id'=>$id));
        }
        // ACTION 12
        public function listerMonstreType($Type) {
            $monstres = $this->getDoctrine()->getRepository(Monstre::class)->findByType($Type);
            return $this->render('Monsterland/listerMonstreType.html.twig',array('monstres' => $monstres,'type' => $Type));
        }

        // ACTION 13
        public function listerRoyaumeMonstreCompte() {
            $royaume = $this->getDoctrine()->getRepository(Royaume::class)->findAll();
            $listType = $this->getDoctrine()->getRepository(Monstre::class)->listType();
            dump($listType);
            $result=array();
            $i=0;
            foreach($royaume as $r){
                $nom=$r->getNom();
                $result1[0]=$nom;
                $j=1;
                foreach($listType as $ltype){
                    $compte=$this->getDoctrine()->getRepository(Royaume::class)->countByType($ltype[1],$r->getId());
                    dump($compte);
                    $result1[$j]=$compte[0]['compte'];
                    $j++;
                }
                $result[$i]=$result1;
                $i++;
            }
            return $this->render('Monsterland/listeMonstreCompte.html.twig',array('result' => $result,'types'=>$listType));
        }

        // ACTION 14
        public function changerRoyaume($id1,$id2) {
            $em = $this->getDoctrine()->getManager();
            $royaume1 = $this->getDoctrine()->getRepository(Royaume::class)->find($id1);
            $royaume2 = $this->getDoctrine()->getRepository(Royaume::class)->find($id2);
            $monstres1 = $this->getDoctrine()->getRepository(Monstre::class)->findByRoyaume($id1);
            $monstres2 = $this->getDoctrine()->getRepository(Monstre::class)->findByRoyaume($id2);
            foreach($monstres1 as $monstre){
                $monstre->setRoyaume($royaume2);
                $em->persist($monstre);
            }
            foreach($monstres2 as $monstre){
                $monstre->setRoyaume($royaume1);
                $em->persist($monstre);
            }
            $em->flush();
            return $this->redirectToRoute('listeMonstre',array());
        }

        // ACTION 15
        public function listeMonstreAll() {
            $repo = $this->getDoctrine()->getManager()->getRepository(Monstre::class);
            $monstre = $repo->listeAll();
            dump($monstre);
            return $this->render('Monsterland/listeMonstreAll.html.twig',array("monstres"=>$monstre));
        }

        // ACTION 16
        public function rechercherMonstre($nom) {
            $repo = $this->getDoctrine()->getManager()->getRepository(Monstre::class);
            $monstre = $repo->rechercherNom($nom);
            dump($monstre);
            return $this->render('Monsterland/listeMonstre.html.twig',array("monstres"=>$monstre));
        }

        // ACTION 17
        public function plusFort() {
            $repo = $this->getDoctrine()->getManager()->getRepository(Monstre::class);
            $monstre = $repo->plusFort();
            dump($monstre);
            return $this->render('Monsterland/listeMonstre.html.twig',array("monstres"=>$monstre));
        }

        // ACTION 18
        public function plusFortRoyaume() {
            $repo = $this->getDoctrine()->getManager()->getRepository(Royaume::class);
            $monstres = $this->getDoctrine()->getManager()->getRepository(Monstre::class)->plusFort();
            $royaume = $repo->findAll();
            $result=array();
            foreach($royaume as $r){
                foreach($monstres as $m){
                    if(($m->getRoyaume()!=null)&& $m->getRoyaume()->getId()==$r->getId()){
                        $nom=$m->getRoyaume()->getNom();
                        $val=$m->getNom();
                        $result[$nom]=$val;
                    }   
                }
            }
            dump($royaume);
            return $this->render('Monsterland/listeMonstrePlusFort.html.twig',array("result"=>$result,"royaumes"=>$royaume));
        }
    }
?>