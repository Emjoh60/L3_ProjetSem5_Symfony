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
        // ACTION 1
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
    }
?>