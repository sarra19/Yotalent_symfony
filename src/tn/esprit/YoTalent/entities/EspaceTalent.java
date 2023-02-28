/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.entities;
import java.util.Objects;



/**
 *
 * @author USER
 */
public class EspaceTalent {
    
private int idEST;
    private String titre;
    private User idU;
    
    private Video idVid;
    private Categorie idCat;
    private Contrat idC;

    public EspaceTalent() {
    }

    public EspaceTalent(String titre, User idU) {
        this.titre = titre;
        this.idU = idU;
    }

    public EspaceTalent(String titre, User idU, Video idVid) {
        this.titre = titre;
        this.idU = idU;
        this.idVid = idVid;
    }

    public EspaceTalent(String titre, User idU, Video idVid, Categorie idCat) {
        this.titre = titre;
        this.idU = idU;
        this.idVid = idVid;
        this.idCat = idCat;
    }
    

    public EspaceTalent(int idEST) {
        this.idEST = idEST;
    }

    public EspaceTalent(String titre) {
        this.titre = titre;
    }
    
    

    public EspaceTalent(String titre, User idU, Video idVid, Categorie idCat, Contrat idC) {
        this.titre = titre;
        this.idU = idU;
        this.idVid = idVid;
        this.idCat = idCat;
        this.idC = idC;
    }

    public EspaceTalent(int idEST, String titre, User idU, Video idVid, Categorie idCat, Contrat idC) {
        this.idEST = idEST;
        this.titre = titre;
        this.idU = idU;
        this.idVid = idVid;
        this.idCat = idCat;
        this.idC = idC;
    }


   

    public int getIdEST() {
        return idEST;
    }

    public void setIdEST(int idEST) {
        this.idEST = idEST;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public User getIdU() {
        return idU;
    }

    public void setIdU(User idU) {
        this.idU = idU;
    }

    public Video getIdVid() {
        return idVid;
    }

    public void setIdVid(Video idVid) {
        this.idVid = idVid;
    }

    public Categorie getIdCat() {
        return idCat;
    }

    public void setIdCat(Categorie idCat) {
        this.idCat = idCat;
    }

    public Contrat getIdC() {
        return idC;
    }

    public void setIdC(Contrat idC) {
        this.idC = idC;
    }

    @Override
    public String toString() {
        return "EspaceTalent{" + "idEST=" + idEST + ", titre=" + titre + ", idU=" + idU + ", idVid=" + idVid + ", idCat=" + idCat + ", idC=" + idC + '}';
    }

    @Override
    public int hashCode() {
        int hash = 7;
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final EspaceTalent other = (EspaceTalent) obj;
        if (this.idEST != other.idEST) {
            return false;
        }
        if (!Objects.equals(this.titre, other.titre)) {
            return false;
        }
        if (!Objects.equals(this.idU, other.idU)) {
            return false;
        }
        if (!Objects.equals(this.idVid, other.idVid)) {
            return false;
        }
        if (!Objects.equals(this.idCat, other.idCat)) {
            return false;
        }
        if (!Objects.equals(this.idC, other.idC)) {
            return false;
        }
        return true;
    }
    

   
    
    
    
    
}



