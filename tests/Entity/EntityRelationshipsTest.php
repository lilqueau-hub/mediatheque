<?php

namespace App\Tests\Entity;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Emprunt;
use App\Entity\Exemplaire;
use App\Entity\Oeuvre;
use App\Entity\TypeOeuvre;
use App\Entity\Utilisateur;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

final class EntityRelationshipsTest extends TestCase
{
    public function testAuteurAndCategorieAssociationsStaySynchronized(): void
    {
        $oeuvre = new Oeuvre();
        $auteur = new Auteur();
        $categorie = new Categorie();

        $auteur->addOeuvre($oeuvre);
        $categorie->addOeuvre($oeuvre);

        self::assertSame([$auteur], $oeuvre->getAuteurs()->toArray());
        self::assertSame([$oeuvre], $auteur->getOeuvres()->toArray());
        self::assertSame([$categorie], $oeuvre->getCategories()->toArray());
        self::assertSame([$oeuvre], $categorie->getOeuvres()->toArray());

        $oeuvre->removeAuteur($auteur);
        $oeuvre->removeCategorie($categorie);

        self::assertCount(0, $auteur->getOeuvres());
        self::assertCount(0, $categorie->getOeuvres());
    }

    public function testExemplaireMovesBetweenOeuvresAndStaysSynchronized(): void
    {
        $premiereOeuvre = new Oeuvre();
        $secondeOeuvre = new Oeuvre();
        $exemplaire = new Exemplaire();

        $exemplaire->setOeuvre($premiereOeuvre);
        $exemplaire->setOeuvre($secondeOeuvre);

        self::assertCount(0, $premiereOeuvre->getExemplaires());
        self::assertSame([$exemplaire], $secondeOeuvre->getExemplaires()->toArray());
        self::assertSame($secondeOeuvre, $exemplaire->getOeuvre());
    }

    public function testChangingTypeKeepsBothSidesAndRejectsRemovingRequiredType(): void
    {
        $premierType = new TypeOeuvre();
        $secondType = new TypeOeuvre();
        $oeuvre = new Oeuvre();

        $premierType->addOeuvre($oeuvre);
        $oeuvre->setTypeOeuvre($secondType);

        self::assertCount(0, $premierType->getOeuvres());
        self::assertSame([$oeuvre], $secondType->getOeuvres()->toArray());
        self::assertSame($secondType, $oeuvre->getTypeOeuvre());

        $this->expectException(\LogicException::class);
        $secondType->removeOeuvre($oeuvre);
    }

    public function testLoanSettersKeepUserAndCopyCollectionsSynchronized(): void
    {
        $utilisateur = new Utilisateur();
        $autreUtilisateur = new Utilisateur();
        $exemplaire = new Exemplaire();
        $autreExemplaire = new Exemplaire();
        $emprunt = new Emprunt();

        $emprunt->setUtilisateur($utilisateur);
        $emprunt->setExemplaire($exemplaire);
        $emprunt->setUtilisateur($autreUtilisateur);
        $emprunt->setExemplaire($autreExemplaire);

        self::assertCount(0, $utilisateur->getEmprunts());
        self::assertSame([$emprunt], $autreUtilisateur->getEmprunts()->toArray());
        self::assertCount(0, $exemplaire->getEmprunts());
        self::assertSame([$emprunt], $autreExemplaire->getEmprunts()->toArray());
        self::assertNotNull($utilisateur->getDateCreation());
        self::assertNotNull($utilisateur->getDateModification());
    }

    public function testPasswordValidationAcceptsRequirementsAtTheFirstCharacter(): void
    {
        $utilisateur = (new Utilisateur())->setMdp('aBCDEFGH1!');
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        self::assertCount(0, $validator->validate($utilisateur));
    }
}
