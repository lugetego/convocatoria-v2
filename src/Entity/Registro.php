<?php

namespace App\Entity;

use App\Repository\RegistroRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: RegistroRepository::class)]
#[ORM\Table(name: 'registro')]
#[Vich\Uploadable]
#[UniqueEntity('mail')]
class Registro
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'nombre', length: 100)]
    #[Assert\NotBlank]
    private ?string $nombre = null;

    #[ORM\Column(name: 'materno', length: 100, nullable: true)]
    private ?string $materno = null;

    #[ORM\Column(name: 'paterno', length: 100)]
    #[Assert\NotBlank]
    private ?string $paterno = null;

    #[ORM\Column(name: 'direccion', length: 500)]
    #[Assert\NotBlank]
    private ?string $direccion = null;

    #[ORM\Column(name: 'mail', length: 255, unique: true)]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $mail = null;

    /**
     * No es un campo mapeado de la entidad, solo una propiedad simple.
     */
    #[Vich\UploadableField(mapping: 'registro_solicitud', fileNameProperty: 'solicitudName')]
    #[Assert\File(
        maxSize: '25M',
        uploadFormSizeErrorMessage: 'El archivo debe ser menor a 25 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $solicitudFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $solicitudName = null;

    #[Vich\UploadableField(mapping: 'registro_cv', fileNameProperty: 'cvName')]
    #[Assert\File(
        maxSize: '25M',
        uploadFormSizeErrorMessage: 'El archivo debe ser menor a 25 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $cvFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cvName = null;

    #[Vich\UploadableField(mapping: 'registro_comprobante', fileNameProperty: 'comprobanteName')]
    #[Assert\File(
        maxSize: '25M',
        uploadFormSizeErrorMessage: 'El archivo debe ser menor a 25 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $comprobanteFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $comprobanteName = null;

    #[Vich\UploadableField(mapping: 'registro_proyecto', fileNameProperty: 'proyectoName')]
    #[Assert\File(
        maxSize: '25M',
        uploadFormSizeErrorMessage: 'El archivo debe ser menor a 25 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $proyectoFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $proyectoName = null;

    #[Vich\UploadableField(mapping: 'registro_articulos', fileNameProperty: 'articulosName')]
    #[Assert\File(
        maxSize: '30M',
        uploadFormSizeErrorMessage: 'El archivo de artículos debe ser menor a 25 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $articulosFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $articulosName = null;

    #[ORM\Column(name: 'ref1nombre', length: 255)]
    #[Assert\NotBlank]
    private ?string $ref1nombre = null;

    #[ORM\Column(name: 'ref1mail', length: 255)]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $ref1mail = null;

    #[Vich\UploadableField(mapping: 'registro_ref1recom', fileNameProperty: 'ref1recomName')]
    #[Assert\File(
        maxSize: '2M',
        uploadFormSizeErrorMessage: 'El archivo debe ser menor a 2 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $ref1recomFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ref1recomName = null;

    #[ORM\Column(name: 'ref2nombre', length: 255)]
    #[Assert\NotBlank]
    private ?string $ref2nombre = null;

    #[ORM\Column(name: 'ref2mail', length: 255)]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $ref2mail = null;

    #[Vich\UploadableField(mapping: 'registro_ref2recom', fileNameProperty: 'ref2recomName')]
    #[Assert\File(
        maxSize: '2M',
        uploadFormSizeErrorMessage: 'El archivo debe ser menor a 2 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $ref2recomFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ref2recomName = null;

    #[ORM\Column(name: 'ref3nombre', length: 255)]
    #[Assert\NotBlank]
    private ?string $ref3nombre = null;

    #[ORM\Column(name: 'ref3mail', length: 255)]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $ref3mail = null;

    #[Vich\UploadableField(mapping: 'registro_ref3recom', fileNameProperty: 'ref3recomName')]
    #[Assert\File(
        maxSize: '2M',
        uploadFormSizeErrorMessage: 'El archivo debe ser menor a 2 MB',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
    public ?File $ref3recomFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ref3recomName = null;

    #[ORM\Column(nullable: true)]
    private ?bool $activo = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setMaterno(?string $materno): static
    {
        $this->materno = $materno;

        return $this;
    }

    public function getMaterno(): ?string
    {
        return $this->materno;
    }

    public function setPaterno(?string $paterno): static
    {
        $this->paterno = $paterno;

        return $this;
    }

    public function getPaterno(): ?string
    {
        return $this->paterno;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setSolicitudFile(?File $solicitud = null): void
    {
        $this->solicitudFile = $solicitud;
        if ($solicitud) {
            // Se requiere que al menos un campo cambie si se usa Doctrine,
            // de lo contrario los listeners no se disparan y el archivo se pierde.
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getSolicitudFile(): ?File
    {
        return $this->solicitudFile;
    }

    public function getSolicitudName(): ?string
    {
        return $this->solicitudName;
    }

    public function setSolicitudName(?string $solicitudName): void
    {
        $this->solicitudName = $solicitudName;
    }

    public function setCvFile(?File $cv = null): void
    {
        $this->cvFile = $cv;
        if ($cv) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function getCvName(): ?string
    {
        return $this->cvName;
    }

    public function setCvName(?string $cvName): void
    {
        $this->cvName = $cvName;
    }

    public function setComprobanteFile(?File $comprobante = null): void
    {
        $this->comprobanteFile = $comprobante;
        if ($comprobante) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getComprobanteFile(): ?File
    {
        return $this->comprobanteFile;
    }

    public function getComprobanteName(): ?string
    {
        return $this->comprobanteName;
    }

    public function setComprobanteName(?string $comprobanteName): void
    {
        $this->comprobanteName = $comprobanteName;
    }

    public function setProyectoFile(?File $proyecto = null): void
    {
        $this->proyectoFile = $proyecto;
        if ($proyecto) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getProyectoFile(): ?File
    {
        return $this->proyectoFile;
    }

    public function getProyectoName(): ?string
    {
        return $this->proyectoName;
    }

    public function setProyectoName(?string $proyectoName): void
    {
        $this->proyectoName = $proyectoName;
    }

    public function setArticulosFile(?File $articulos = null): void
    {
        $this->articulosFile = $articulos;
        if ($articulos) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getArticulosFile(): ?File
    {
        return $this->articulosFile;
    }

    public function getArticulosName(): ?string
    {
        return $this->articulosName;
    }

    public function setArticulosName(?string $articulosName): void
    {
        $this->articulosName = $articulosName;
    }

    public function setRef1nombre(?string $ref1nombre): static
    {
        $this->ref1nombre = $ref1nombre;

        return $this;
    }

    public function getRef1nombre(): ?string
    {
        return $this->ref1nombre;
    }

    public function setRef1mail(?string $ref1mail): static
    {
        $this->ref1mail = $ref1mail;

        return $this;
    }

    public function getRef1mail(): ?string
    {
        return $this->ref1mail;
    }

    public function setRef1recomFile(?File $ref1recom = null): void
    {
        $this->ref1recomFile = $ref1recom;
        if ($ref1recom) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getRef1recomFile(): ?File
    {
        return $this->ref1recomFile;
    }

    public function getRef1recomName(): ?string
    {
        return $this->ref1recomName;
    }

    public function setRef1recomName(?string $ref1recomName): void
    {
        $this->ref1recomName = $ref1recomName;
    }

    public function setRef2nombre(?string $ref2nombre): static
    {
        $this->ref2nombre = $ref2nombre;

        return $this;
    }

    public function getRef2nombre(): ?string
    {
        return $this->ref2nombre;
    }

    public function setRef2mail(?string $ref2mail): static
    {
        $this->ref2mail = $ref2mail;

        return $this;
    }

    public function getRef2mail(): ?string
    {
        return $this->ref2mail;
    }

    public function setRef2recomFile(?File $ref2recom = null): void
    {
        $this->ref2recomFile = $ref2recom;
        if ($ref2recom) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getRef2recomFile(): ?File
    {
        return $this->ref2recomFile;
    }

    public function getRef2recomName(): ?string
    {
        return $this->ref2recomName;
    }

    public function setRef2recomName(?string $ref2recomName): void
    {
        $this->ref2recomName = $ref2recomName;
    }

    public function setRef3nombre(?string $ref3nombre): static
    {
        $this->ref3nombre = $ref3nombre;

        return $this;
    }

    public function getRef3nombre(): ?string
    {
        return $this->ref3nombre;
    }

    public function setRef3mail(?string $ref3mail): static
    {
        $this->ref3mail = $ref3mail;

        return $this;
    }

    public function getRef3mail(): ?string
    {
        return $this->ref3mail;
    }

    public function setRef3recomFile(?File $ref3recom = null): void
    {
        $this->ref3recomFile = $ref3recom;
        if ($ref3recom) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getRef3recomFile(): ?File
    {
        return $this->ref3recomFile;
    }

    public function getRef3recomName(): ?string
    {
        return $this->ref3recomName;
    }

    public function setRef3recomName(?string $ref3recomName): void
    {
        $this->ref3recomName = $ref3recomName;
    }

    public function setActivo(?bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
