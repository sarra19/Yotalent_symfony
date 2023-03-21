package tn.esprit.YoTalent.services;

import tn.esprit.YoTalent.entities.Video;
import tn.esprit.YoTalent.utils.MaConnexion;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.sql.PreparedStatement;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

public class ServiceVideo implements IService<Video> {
    private Connection cnx;
    private List<Video> videos;

    public ServiceVideo(){
        cnx = MaConnexion.getInstance().getCnx();
        videos = new ArrayList<>();
    }

    @Override
    public void createOne(Video video) throws SQLException {
        String req = "INSERT INTO `video`(`nomVid`,`url`) VALUES (?,?)";
        PreparedStatement pst = cnx.prepareStatement(req);
        pst.setString(1, video.getNomVid());
        pst.setString(2, video.getUrl());
        pst.executeUpdate();
        System.out.println("Video ajouté !");
        videos.add(video);
    }

    @Override
    public void updateOne(Video video) throws SQLException {
        String req = "UPDATE video SET `nomVid`=?, `url`=? WHERE idVid=?";
        PreparedStatement pst = cnx.prepareStatement(req);
        pst.setString(1, video.getNomVid());
        pst.setString(2, video.getUrl());
        pst.setInt(3, video.getIdVid());
        pst.executeUpdate();
        System.out.println("Video " + video.getNomVid() + " mise à jour avec succès");
        for (int i = 0; i < videos.size(); i++) {
            if (videos.get(i).getIdVid() == video.getIdVid()) {
                videos.set(i, video);
                break;
            }
        }
    }

    @Override
    public void deletOne(Video video) throws SQLException {
        String req = "DELETE FROM video WHERE idVid=?";
        PreparedStatement pst = cnx.prepareStatement(req);
        pst.setInt(1, video.getIdVid());
        pst.executeUpdate();
        System.out.println("Video supprimée avec succès");
        videos.remove(video);
    }

    @Override
    public List<Video> selectAll() throws SQLException {
        List<Video> temp = new ArrayList<>();

        String req = "SELECT * FROM `Video`";
        PreparedStatement ps = cnx.prepareStatement(req);

        ResultSet rs = ps.executeQuery();

        while (rs.next()){
            Video Cat = new Video();
            Cat.setIdVid(rs.getInt(1));
            Cat.setNomVid(rs.getString("nomVid"));
            Cat.setUrl(rs.getString("url"));
            temp.add(Cat);
        }
        videos = temp;
        return temp;
    }

    public Video selectOne(int id) throws SQLException {
        Video video = null;
        String req = "SELECT * FROM video WHERE idVid=?";
        PreparedStatement pst = cnx.prepareStatement(req);
        pst.setInt(1, id);
        ResultSet rs = pst.executeQuery();
        if (rs.next()) {
            video = new Video();
            video.setIdVid(rs.getInt("idVid"));
            video.setNomVid(rs.getString("nomVid"));
            video.setUrl(rs.getString("url"));
        }
        return video;
    }

 public ObservableList<Video> FetchVid() throws SQLException {
    videos = new ArrayList<>();
    ObservableList<Video> videoList = FXCollections.observableArrayList();
    String req = "SELECT * FROM video";
    PreparedStatement ps = cnx.prepareStatement(req);
    ResultSet rs = ps.executeQuery();

    while (rs.next()){
        Video vid = new Video();
        vid.setIdVid(rs.getInt(1));
        vid.setNomVid(rs.getString("nomVid"));
        vid.setUrl(rs.getString("url"));

        videos.add(vid);
        videoList.add(vid);
    }
    return videoList;
}

                    }