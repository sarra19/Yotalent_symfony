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
 
     private int idU;
     private int idVid;
      private int idCat;
    private int idC;
    //   private User idU;
  //  private Video idVid;
  /*  private Categorie idCat;
    private Contrat idC;*/

    public EspaceTalent() {
    }

    public EspaceTalent(String titre, int idU, int idVid, int idCat, int idC) {
        this.titre = titre;
        this.idU = idU;
        this.idVid = idVid;
        this.idCat = idCat;
        this.idC = idC;
    }

  

    public EspaceTalent(int idEST, String titre, int idU, int idVid, int idCat, int idC) {
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

    public int getIdU() {
        return idU;
    }

    public void setIdU(int idU) {
        this.idU = idU;
    }

    public int getIdVid() {
        return idVid;
    }

    public void setIdVid(int idVid) {
        this.idVid = idVid;
    }

    public int getIdCat() {
        return idCat;
    }

    public void setIdCat(int idCat) {
        this.idCat = idCat;
    }

    public int getIdC() {
        return idC;
    }

    public void setIdC(int idC) {
        this.idC = idC;
    }

    @Override
    public String toString() {
        return "EspaceTalent{" + "idEST=" + idEST + ", titre=" + titre + ", idU=" + idU + ", idVid=" + idVid + ", idCat=" + idCat + ", idC=" + idC + '}';
    }

    @Override
    public int hashCode() {
        int hash = 3;
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
        if (this.idU != other.idU) {
            return false;
        }
        if (this.idVid != other.idVid) {
            return false;
        }
        if (this.idCat != other.idCat) {
            return false;
        }
        if (this.idC != other.idC) {
            return false;
        }
        return true;
    }
    
    

   
    
}

  